<?php

namespace ActivatorAdmin\Lib;

class ConfigHelper
{
    private $config;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__.'/../config/config.ini', true);
    }

    public function get($key)
    {
        return $this->config[$key];
    }

}
