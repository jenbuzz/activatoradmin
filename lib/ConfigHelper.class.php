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

    public function get($section, $key=false)
    {
        if (isset($this->config[$section])) {
            if ($key && isset($this->config[$section][$key])) {
                return $this->config[$section][$key];
            } else {
                return $this->config[$section];
            }
        } else {
            throw new \ErrorException('Error: '.$section.' - '.$key.' is not set in config.ini');
        }
    }

}

