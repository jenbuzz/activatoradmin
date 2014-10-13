<?php

namespace ActivatorAdmin\Lib;

class AuthMiddleware extends \Slim\Middleware
{
  public function call()
  {
      $authenticate = function($app) {
          return function() use ($app) {
              $route = $app->router->getCurrentRoute()->getPattern();
            
              if ($route!='/login') {
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
