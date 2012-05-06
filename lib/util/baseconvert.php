<?php

/* $Id: baseconvert.php 98 2012-04-25 05:04:25Z qiao $ */

class util_baseconvert {

    public static $base_DEC = "0123456789";
    public static $base_HEX = "0123456789abcdef";
    public static $base_SSS = "0123456789bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
    public static $base_62 = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    public static function md5($str){
        return self::big(md5($str), self::$base_HEX, self::$base_SSS);
    }

    public static function int($val){
        return self::big($val, self::$base_DEC, self::$base_SSS);
    }

    public static function big ($numstring, $frombase, $tobase)
    {
        $from_count = strlen($frombase);
        $to_count = strlen($tobase);
        $length = strlen($numstring);
        $result = '';
        for ($i = 0; $i < $length; $i++)
        {
            $number[$i] = strpos($frombase, $numstring{$i});
        }
        do // Loop until whole number is converted
        {
            $divide = 0;
            $newlen = 0;
            for ($i = 0; $i < $length; $i++) // Perform division manually (which is why this works with big numbers)
            {
                $divide = $divide * $from_count + $number[$i];
                if ($divide >= $to_count)
                {
                    $number[$newlen++] = (int)($divide / $to_count);
                    $divide = $divide % $to_count;
                }
                elseif ($newlen > 0)
                {
                    $number[$newlen++] = 0;
                }
            }
            $length = $newlen;
            $result = $tobase{$divide} . $result; // Divide is basically $numstring % $to_count (i.e. the new character)
        }
        while ($newlen != 0);
        return $result;
    }

}
