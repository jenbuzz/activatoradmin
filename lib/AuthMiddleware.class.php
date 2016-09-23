<?php

namespace ActivatorAdmin\Lib;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * AuthMiddleware is a custom Slim Middleware class used for authentication.
 * It is used in index.php during setup of the Slim app.
 */
class AuthMiddleware
{
    /**
     * Run login check before further app code is started.
     * The session variable 'activatoradmin_user' is being checked.
     *
     * @param Psr\Http\Message\RequestInterface  $request
     * @param Psr\Http\Message\ResponseInterface $response
     * @param callable                           $next
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $route = $request->getUri()->getPath();

        if ($route !== '/login' && $route !== 'login') {
            $objConfigHelper = new ConfigHelper();
            $baseurl = $objConfigHelper->get('url', 'baseurl');

            if (!isset($_SESSION['activatoradmin_user'])) {
                return $response->withStatus(302)->withHeader('Location', $baseurl.'login');
            }
        }

        return $next($request, $response);
    }
}
