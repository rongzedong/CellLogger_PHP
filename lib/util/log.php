<?php

class util_log {

    public static $log_file = '/tmp/app-tmp.log';

    public static function logfile($file) {
        self::$log_file = $file;
    }

    public static function i($msg){
        self::save('INFO', $msg);
    }

    public static function d($msg){
        self::save('DEBUG', $msg);
    }

    public static function w($msg){
        self::save('WARN', $msg);
    }

    public static function e($msg){
        self::save('ERROR', $msg);
    }

    public static function v($msg){
        self::save('VERBOSE', $msg);
    }

    public static function save($level, $message){
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $level . ' ' . $message . "\n";
        error_log($line, 3, self::$log_file);
    }
}
