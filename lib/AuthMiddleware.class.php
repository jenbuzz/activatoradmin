<?php
/**
 * AuthMiddleware is a custom Slim Middleware class used for authentication.
 * It is used in index.php during setting up the Slim app.
 *
 */
namespace ActivatorAdmin\Lib;

class AuthMiddleware extends \Slim\Middleware
{
  /**
   * Function from the abstract class  \Slim\Middleware.
   * Using the hook "slim.before.dispatch" it is being verified if the use is logged in.
   * The session variable 'activatoradmin_user' is being checked.
   */
  public function call()
  {
      $authenticate = function($app) {
          return function() use ($app) {
              $route = $app->router->getCurrentRoute()->getPattern();
            
              if ($route!=='/login') {
                  $objConfigHelper = $app->config('custom');
                  $baseurl = $objConfigHelper->get('url', 'baseurl');

                  if (!isset($_SESSION['activatoradmin_user'])) {
                      return $app->redirect($baseurl.'login');
                  }
              }
          };
      };

      $this->app->hook('slim.before.dispatch', $authenticate($this->app));

      $this->next->call();
  }
}
