<?php

// Starting PHP session here until Slim-Http-Cookies lib is ready.
if (!headers_sent()) {
    session_start();
}

require_once __DIR__ . '/lib/autoload.php';

use ActivatorAdmin\Lib\ConfigHelper;
use ActivatorAdmin\Lib\ModelFacade;
use ActivatorAdmin\Lib\Item;
use ActivatorAdmin\Lib\AuthMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create container.
$container = new Slim\Container;

// Register view in container.
$container['view'] = function ($c) {
    $view = new Slim\Views\Twig(__DIR__ . '/templates', [
        'cache' => false
    ]);
    $view->addExtension(new Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

// Register confighelper in container.
$container['config'] = function ($c) {
    return new ConfigHelper();
};

// Register logger in container.
$container['logger'] = function ($c) {
    $objLogger = new Logger('activatoradmin');
    $objLogger->pushHandler(new StreamHandler('docs/activatoradmin.log', Logger::WARNING));

    return $objLogger;
};

// Instantiate slim application.
$app = new Slim\App($container);

// Authentication check using a custom middleware class.
$app->add(new AuthMiddleware());

/**
 * Render startup template (index).
 */
$app->get('/', function ($request, $response, $args) {
    $objConfigHelper = $this->config;
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    return $this->view->render($response, 'index.tpl', array(
        'baseurl' => $baseurl,
    ));
});


/**
 * Login.
 */
$app->get('/login', function ($request, $response, $args) {
    $objConfigHelper = $this->config;
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    return $this->view->render($response, 'login.tpl', array(
        'baseurl' => $baseurl,
        'isLogin' => true,
    ));
});
$app->post('/login', function ($request, $response, $args) {
    $objConfigHelper = $this->config;
    $baseurl = $objConfigHelper->get('url', 'baseurl');
    $login = $objConfigHelper->get('login');

    if ($request->getParam('username')===$login['username'] && 
        password_verify($request->getParam('password'), $login['password'])) {

        $_SESSION['activatoradmin_user'] = password_hash('activatoradmin_'.$login['username'], PASSWORD_DEFAULT);

        return $response->withStatus(200)->withHeader('Location', $baseurl);
    } else {
        // Log unsuccessful login attempts.
        if ($objConfigHelper->get('logging', 'log')) {
            $objLogger = $this->logger;
            $objLogger->addWarning('Login Attempt Failed. Username: '.$request->getParam('username'));
        }

        return $this->view->render($response, 'login.tpl', array(
            'baseurl' => $baseurl,
            'isLogin' => true,
            'isError' => true,
        ));
    }
});
$app->get('/logout', function ($request, $response, $args) {
    unset($_SESSION['activatoradmin_user']);

    $objConfigHelper = $this->config;
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    return $response->withStatus(200)->withHeader('Location', $baseurl.'login');
});


/**
 * GET all items.
 */
$app->get('/items', function ($request, $response, $args) {
    $arrItems = array();

    $objModelFacade = new ModelFacade(new Item());
    $arrItemObjects = $objModelFacade->loadAll();
    foreach ($arrItemObjects as $objItem) {
        $arrItems[] = $objItem->toArray();
    }

    echo json_encode($arrItems);
});

/**
 * GET a single item.
 */
$app->get('/items/{id}', function ($request, $response, $args) {

    $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
    if ($id>0 && is_numeric($id)) {
        $objModelFacade = new ModelFacade(new Item());
        $objItem = $objModelFacade->load($id);

        echo json_encode($objItem->toArray());
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * PUT (update) a single item.
 */
$app->put('/item/{id}', function ($request, $response, $args) {
    $id = filter_var($args['id'], FILTER_SANITIZE_STRING);
    if ($id) {
        $request = json_decode($request->getBody());

        if (is_object($request) && isset($request->isactive)) {
            $objModelFacade = new ModelFacade(new Item());
            $objItem = $objModelFacade->load($id);
            $objItem->setIsActive($request->isactive);
            $objItem->save();
        } else {
            echo json_encode(array('success'=>false));
        }
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * DELETE a single item.
 */
$app->delete('/item/{id}', function ($request, $response, $args) {
    $id = filter_var($args['id'], FILTER_SANITIZE_STRING);
    if ($id) {
        $objModelFacade = new ModelFacade(new Item());
        $objItem = $objModelFacade->load($id);
        $objItem->delete();

        echo json_encode(array('success'=>true));
    } else {
        echo json_encode(array('success'=>false));
    }
});

/**
 * GET search items.
 */
$app->get('/search/{term}', function ($request, $response, $args) {
    $term = filter_var($args['term'], FILTER_SANITIZE_STRING);

    $arrItems = array();

    $objModelFacade = new ModelFacade(new Item());
    $arrItemObjects = $objModelFacade->search($term);
    foreach ($arrItemObjects as $objItem) {
        $arrItems[] = $objItem->toArray();
    }

    echo json_encode($arrItems);
});

/**
 * GET statistics page.
 */
$app->get('/stats', function ($request, $response, $args) {
    $objConfigHelper = $this->config;
    $baseurl = $objConfigHelper->get('url', 'baseurl');

    return $this->view->render($response, 'stats.tpl', array(
        'baseurl' => $baseurl,
        'isStats' => true,
    ));
});

/**
 * GET statistics (active/deactive count).
 */
$app->get('/get-stats', function ($request, $response, $args) {
    $objModelFacade = new ModelFacade(new Item());

    $countActivate = $objModelFacade->countActiveStatus(true);
    $countInactivate = $objModelFacade->countActiveStatus(false);

    echo json_encode(array(
        array(
            'name' => 'active',
            'value' => $countActivate,
        ), 
        array (
            'name' => 'inactive',
            'value' => $countInactivate,
        ),
    ));
});

// Start slim application.
$app->run();
