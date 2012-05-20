<?php

ob_start();

$_SERVER['APP_ROOT']    = dirname(__FILE__);
$_SERVER['APP_RELEASE'] = 'dev';

// set include path
$paths = array(
    $_SERVER['APP_ROOT'] . '/lib',
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $paths));
unset($paths);

// boot 
require_once 'function.php';

// load config
config::load('cl');

// load locale 

// set log file
util_log::logfile('/tmp/cl.log');

// compatibility

