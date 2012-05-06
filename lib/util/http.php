<?php

class util_http {

    public static function expire_header () {

        if(empty(config::$settings['allowCache'])) {
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Tue, 29 Sep 2009 03:17:07 GMT");
        }

    }

}
