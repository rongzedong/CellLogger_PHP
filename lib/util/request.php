<?php

class util_request {

    public static function get($name, $default = '', $trim = true){
        return self::getVar($_GET, $name, $default);
    }

    public static function post($name, $default = '', $trim = true){
        return self::getVar($_POST, $name, $default);
    }

    public static function request($name, $default = '', $trim = true){
        return self::getVar($_REQUEST, $name, $default);
    }

    public static function cookie($name, $default = '', $trim = true){
        return self::getVar($_COOKIE, $name, $default);
    }

    public static function server($name, $default = '', $trim = true){
        return self::getVar($_SERVER, $name, $default);
    }

    public static function getVar($array, $name, $default, $trim = true){
        if(isset($array[$name])){
            $val = $array[$name];
            if(is_string($val)){
                $val = trim($val);
            }
            return $val;
        } else {
            return $default;
        }
    }

}
