<?php

/* $Id: base.php 98 2012-04-25 05:04:25Z qiao $ */

class dao_base {

    protected static $errors = array();

    public static function addError($e) {
        self::$errors[] = $e;
    }
    public static function getError() {
        return self::$errors[0];
    }
    public static function getErrorList() {
        return self::$errors;
    }
    public static function clearError() {
        self::$errors = array();
    }

    protected static $platform = '';
    public static function setPlatform($p){
        self::$platform = $p;
    }
    public static function getPlatform(){
        return self::$platform;
    }

    protected static $_db = array();

    protected function getMysqli($setting = null){
        if($setting == null){
            $setting = config::$settings['mysql'];
        }
        ksort($setting);
        $key = http_build_query($setting);
        if(empty(self::$_db[$key])) {
            self::$_db[$key] = $this->newMysqli($setting);
            // error_log('create new db: ' . $key);
        }
        return self::$_db[$key];
    }

    protected function newMysqli($setting){

        $mysqli = null;
        if(isset($setting['port'])){
            $mysqli = new mysqli($setting['host'], $setting['username'], $setting['password'], $setting['dbname'], $setting['port']);
        } else {
            $mysqli = new mysqli($setting['host'], $setting['username'], $setting['password'], $setting['dbname']);
        }

        if ($mysqli->connect_error) {
            echo 'Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error;
        }

        if (!$mysqli->set_charset("utf8")) {
            echo 'Error loading character set utf8: ' . $mysqli->error;
            exit;
        }

        return $mysqli;
    }

    protected static $_mc = array();

    protected function getMemcache($setting = null){
        if($setting == null){
            $setting = config::$settings['memcache'];
        }
        ksort($setting);
        $key = http_build_query($setting);
        if(empty(self::$_mc[$key])) {
            self::$_mc[$key] = $this->newMemcache($setting);
            // error_log('create new mc: ' . $key. ' ' . var_export(self::$_mc, true));
        }
        return self::$_mc[$key];
    }

    protected function newMemcache($setting){
        $mc = new Memcache();
        foreach( $setting as $server){
            $mc->addServer($server, 11211);
        }
        return $mc;
    }

    protected function sqlInsert($mysqli, $info){

        assert(!empty($info));

        $fields = array();
        $values = array();

        foreach($info as $field => $value) {
            $fields[] = $field;
            $values[] = $mysqli->real_escape_string($value);
        }


        $f = '`' . implode('`,`', $fields) . '`' ;
        $v = '\'' . implode('\',\'', $values) . '\'' ;

        return array($f, $v);
    }

    protected function sqlUpdate($mysqli, $info){

        assert(!empty($info));

        $updates = array();

        foreach($info as $field => $value) {

            $update = '`';
            $update .= $field;
            $update .= '` = \'';
            $update .= $mysqli->real_escape_string($value);
            $update .= '\'';

            $updates[] = $update;
        }

        return implode(', ', $updates);
    }
}

