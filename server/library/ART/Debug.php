<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 14. 12. 08.
 * Time: 19:33
 */

namespace ART;


class Debug {

    static public function dump($var, $is_plain_text = false)
    {
        if (!$is_plain_text) {
            $format = "<pre>%s</pre>";
        } else {
            $format = "%s";
        }

        $debug = sprintf($format, print_r($var, true));
        print_r($debug);
    }

    static public function file($var, $title = "", $is_plain_text = false)
    {
        $log_dir = "/../log/";
//        if (!is_dir($log_dir)) {
//            chmod($log_dir, 0777);
//        }

        $file = APP_PATH . "/../log/" . "debug.log";
        if ($is_plain_text) {
            $format = "<pre>%s</pre>";
        } else {
            $format = "%s";
        }

        $separator = "\n$title ----------------------------------------------------------------------------------------------\n";
        $debug = sprintf("$separator $format", print_r($var, true));

        if (file_exists($file)) {
            chmod($file, 0777);
        }

        file_put_contents($file, $debug, FILE_APPEND);
    }
}