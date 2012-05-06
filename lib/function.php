<?php

function __autoload($class_name) {
    if(!preg_match("#[0-9a-zA-Z\_]#", $class_name)) {
        echo 'bad autoload class_name: ' . $class_name;
        exit;
    }
    $pathname = str_replace('_', '/', $class_name);

    // error_log(date("Y-m-d H:i:s") . ' autoload: ' . $class_name . "\n", 3, "/tmp/bbs-autoload.log");
    require_once $pathname . '.php';
}


function l($k) {
    global $LANG;

    if(isset(config::$lang[$k])) {
        return config::$lang[$k];
    } else {
        return 'lang:'.$k; 
    }
}

function get_ref() {
    if(!empty($_GET['fb_source'])) {
        return $_GET['fb_source'];
    }

    if(!empty($_GET['fb_ref'])) {
        return $_GET['fb_ref'];
    }

    if(!empty($_GET['ref'])) {
        return $_GET['ref'];
    }

    return null;
}

function get_protocol() {
    if($_SERVER["SERVER_PORT"] == 443) {
        return 'https:';
    }
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ) {
        return 'https:';
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        return 'https:';
    }

    return 'http:';
}

// fixme , DO NOT get ip behind proxy
function get_ip() {
    return $_SERVER['REMOTE_ADDR'];
}

function get_user_random_key($uid) {
    $s = '1';

    $s1 = util_baseconvert::int(''.$uid);
    $s1 = substr(sprintf('%032s', $s1), -7);

    $s2 = substr(sprintf('%032s', util_baseconvert::int(''.mt_rand())), -4);

    $s3 = substr(sprintf('%032s', util_baseconvert::md5(uniqid('', true))), 8, 24);

    return implode('', array($s, $s1, $s2, $s3));
}

function function_walk_intval(&$item, $key) {
    $item = number_format($item, 0, '', '');
}

function get_browser_class_name(){
    $t = browser_class_names();
    return implode(' ', $t);
}

function browser_class_names() {
    $classes = array();
    // add 'class-name' to the $classes array
    // $classes[] = 'class-name';
    $browser = $_SERVER[ 'HTTP_USER_AGENT' ];

    // Mac, PC ...or Linux
    if ( preg_match( "/Mac/", $browser ) ){
        $classes[] = 'mac';

    } elseif ( preg_match( "/Windows/", $browser ) ){
        $classes[] = 'windows';

    } elseif ( preg_match( "/Linux/", $browser ) ) {
        $classes[] = 'linux';

    } else {
        $classes[] = 'unknown-os';
    }

    // Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
    if ( preg_match( "/Chrome/", $browser ) ) {
        $classes[] = 'chrome';

        preg_match( "/Chrome\/(\d+.\d+)/si", $browser, $matches);
        $ch_version = 'ch' . str_replace( '.', '-', $matches[1] );
        $classes[] = $ch_version;

    } elseif ( preg_match( "/Safari/", $browser ) ) {
        $classes[] = 'safari';

        preg_match( "/Version\/(\d+.\d+)/si", $browser, $matches);
        $sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
        $classes[] = $sf_version;

    } elseif ( preg_match( "/Opera/", $browser ) ) {
        $classes[] = 'opera';

        preg_match( "/Opera\/(\d+.\d+)/si", $browser, $matches);
        $op_version = 'op' . str_replace( '.', '-', $matches[1] );
        $classes[] = $op_version;

    } elseif ( preg_match( "/MSIE/", $browser ) ) {
        $classes[] = 'msie';

        if( preg_match( "/MSIE 6.0/", $browser ) ) {
            $classes[] = 'ie6';
        } elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
            $classes[] = 'ie7';
        } elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
            $classes[] = 'ie8';
        }

    } elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
        $classes[] = 'firefox';

        preg_match( "/Firefox\/(\d+)/si", $browser, $matches);
        $ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
        $classes[] = $ff_version;

    } else {
        $classes[] = 'unknown-browser';
    }
    // return the $classes array
    return $classes;
}


// $t = browser_class_names(array());
// print_r($t);

