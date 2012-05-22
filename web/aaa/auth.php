<?php



if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="CL"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access Restricted';
    exit;
} else {

    $auth_file = $_SERVER['APP_ROOT'] . '/passwd';

    $auth = util_auth::check($auth_file, $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
    if(!$auth)  {
        header('WWW-Authenticate: Basic realm="CL"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Login Failed';
        exit;
    }
}

