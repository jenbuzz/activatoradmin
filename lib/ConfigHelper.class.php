<?php

namespace ActivatorAdmin\Lib;

class ConfigHelper
{
    private $config;

    public function __construct()
    {
        $this->config = @parse_ini_file(__DIR__.'/../config/config.ini', true);
        if (!$this->config) {
            throw new \ErrorException('Error: config.ini could not be loaded');
        }
    }

    public function get($key)
    {
        if (isset($this->config[$key])) {
          return $this->config[$key];
        } else {
            throw new \ErrorException('Error: '.$key.' is not set in config.ini');
        }
    }

}
