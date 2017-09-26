<?php

class Url
{

    static function part($number)
    {
        $url = explode("?", $_SERVER["REQUEST_URI"]);
        $parts = explode("/", $url[0]);
        return (isset($parts[$number])) ? $parts[$number] : false;
    }

    static function post($key)
    {
        return (isset($_POST[$key])) ? $_POST[$key] : false;
    }

    static function get($key)
    {
        return (isset($_GET[$key])) ? urldecode($_GET[$key]) : false;
    }

    static function request($key)
    {
        if (self::get($key)) {
            return self::get($key);
        } else if (self::post($key)) {
            return self::post($key);
        } else {
            return false;
        }
    }

    static function build($url, $parms = [])
    {
        if (strpos($url, "//") == false) {
            $prefix = "//" . $GLOBALS["config"]["domain"];
        } else {
            $prefix = "";
        }
        $append = "";
        foreach ($parms as $key => $parm) {
            $append .= ($append == "") ? "?" : "&";
            $append .= urlencode($key) . "=" . urlencode($append);
        }
        return $prefix . $append;
    }

    static function simple($url){
        if (strpos($url, "//") == false) {
            $prefix = "//" . $GLOBALS["config"]["domain"];
        } else {
            $prefix = "";
        }

        return $prefix;
    }

    static function redir($to, $exit = true){
        if (headers_sent()){
            echo "<script>window.location = '{$to}';</script>";
        }else{
            header("location: {$to}");
        }
        if ($exit){
            die();
        }
    }
}

?>