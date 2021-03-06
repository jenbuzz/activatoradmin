<?php

namespace ActivatorAdmin\Lib;

/**
 * ConfigHelper loads the config.ini file and makes the settings accessible through a get function.
 */
class ConfigHelper
{
    private $config;

    /**
     * Loads the config.ini file.
     */
    public function __construct()
    {
        $this->config = @parse_ini_file(__DIR__.'/../config/config.ini', true);
        if (!$this->config) {
            throw new \ErrorException('Error: config.ini could not be loaded');
        }
    }

    /**
     * Get config settings from config.ini. Get a whole section or a specific key.
     *
     * @param string $section is the name of the section in the config.ini file. Returns all settings as array
     * @param string $key     is the name of a single key/entry in the config.ini file
     *
     * @return array|string
     */
    public function get(string $section, string $key = '')
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
