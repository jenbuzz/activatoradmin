<?php

namespace ActivatorAdmin\Lib;

use ActivatorAdmin\Lib\ConfigHelper;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * AuthMiddleware is a custom Slim Middleware class used for authentication.
 * It is used in index.php during setting up the Slim app.
 *
 */
class AuthMiddleware
{
  /**
   * Function from the abstract class  \Slim\Middleware.
   * Using the hook "slim.before.dispatch" it is being verified if the use is logged in.
   * The session variable 'activatoradmin_user' is being checked.
   */
  function __invoke(Request $req,  Response $res, callable $next)
  {
      $route = $req->getUri()->getPath();

      if ($route!=='login') {
          $objConfigHelper = new ConfigHelper();
          $baseurl = $objConfigHelper->get('url', 'baseurl');

          if (!isset($_SESSION['activatoradmin_user'])) {
              return $res->withStatus(302)->withHeader('Location', $baseurl.'login');
          }
      }

      $newResponse = $next($req, $res);

      return $newResponse;
  }
}
