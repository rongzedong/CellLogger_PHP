<?php

class util_auth {
    public static function check($file, $user, $pass) {
        if(empty($user) or empty($pass)) {
            return false;
        }
        if(!file_exists($file) or !is_readable($file)) {
            return false; 
        }

        $lines = file($file);
        foreach($lines as $line){
            $line = trim($line);
            list($fuser,$fpass)=explode(':',$line);
            if($fuser==$user){
                $salt=substr($fpass,0,2);

                $test_pw=crypt($pass,$salt);

                return $test_pw == $fpass;

            } 
        } 

        return false;
    }
}
