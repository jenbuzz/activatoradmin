<?php

namespace ActivatorAdmin\Lib;

use ActivatorAdmin\Lib\ConfigHelper;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * AuthMiddleware is a custom Slim Middleware class used for authentication.
 * It is used in index.php during setup of the Slim app.
 *
 */
class AuthMiddleware
{
  /**
   * Run login check before further app code is started.
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
