<?php

/* $Id: config.php 98 2012-04-25 05:04:25Z qiao $ */

class config {

    /**
     * app setting
     */
    public static $settings = array();

    /**
     * config loader
     */
    public static function load($app) {

        if(empty($_SERVER['APP_ROOT']) or empty($_SERVER['APP_RELEASE'])) {
            echo 'app env setting error.';exit;
        }

        $file = $_SERVER['APP_ROOT'] . '/config/' . $_SERVER['APP_RELEASE'] . '-' . $app . '.php';

        require_once $file;

        self::$settings['config_file_loaded'] = $file;
    }
}


config::$settings['memcache'] = array(
    '127.0.0.1',
);

config::$settings['mysql'] = array(
    'host'      => '127.0.0.1',
    'username'  => 'username',
    'password'  => 'password',
    'dbname'    => 'test',
);



