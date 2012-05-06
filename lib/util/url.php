<?php

/* $Id: url.php 98 2012-04-25 05:04:25Z qiao $ */

class util_url {

    /**
     * safe to add printf format
     */
    public static function add_param($url, $name, $value, $encodeValue = true){
        @ list($path, $query_string) = explode('?', $url);
        parse_str($query_string, $query);

        if($encodeValue){
            $query[$name] = $value;
            
            $new_url = $path . '?' . http_build_query($query);

        } else {
            unset($query[$name]);

            $new_url = $path . '?';

            if(!empty($query)){
                $new_url .= http_build_query($query) . '&';
            }

            $new_url .= urlencode($name).'='.$value;
        }

        return $new_url;
    }

}

/*
$url = '/?module=crawler&action=list&table=7k7k';
echo q_url::add_param($url, 'page', 12);
 */

