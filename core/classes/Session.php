<?php
class Session{

    private static $instance;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
        foreach ($_COOKIE as $key => $value){
            if (!isset($_SESSION[$key])){
                json_decode($value);
                if (json_last_error() == JSON_ERROR_NONE){
                    $_SESSION[$key] = json_decode($value);
                }else{
                    $_SESSION[$key] = $value;
                }
            }
        }
    }

    static function check($key){
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        if(is_array($key)){
            $set = true;
            foreach ($key as $k){
                if (!self::check($k)){
                    $set = false;
                }
            }
            return $set;
        }else{
            $key = self::generateSessionKey($key);

            return isset($_SESSION[$key]);
        }
    }

    static function get($key){
        if (!isset($_SESSION[self::generateSessionKey($key)])){
            return $_SESSION[self::generateSessionKey($key)];
        }else{
            return false;
        }
    }

    static public function set($key, $value, $ttl=0){
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        $_SESSION[self::generateSessionKey($key)] = $value;
        var_dump($key);

        $_SESSION['test']= 'test';

        var_dump(self::generateSessionKey($key));
        echo "</br>";

        if ($ttl != 0){
            if (is_object($value) || is_array($value)){
                $value = json_decode($value);
            }
            setcookie(self::generateSessionKey($key),$value,(time()+$ttl),"/",$_SERVER["HTTP_HOST"]);
        }
    }

    static function kill($key){
        if (isset($_SERVER[self::generateSessionKey($key)])){
            unset($_SERVER[self::generateSessionKey($key)]);
        }
        if (isset($_COOKIE[self::generateSessionKey($key)])){
            setcookie(self::generateSessionKey($key), "" ,(time() - 5000),"/",$_SERVER["HTTP_HOST"]);
        }
    }

    static function endSession(){
        foreach ($_SESSION as $key => $value){
            unset($_SESSION[$key]);
        }
        foreach ($_COOKIE as $key => $value){
            setcookie($key, "" ,(time() - 5000),"/",$_SERVER["HTTP_HOST"]);
        }
        session_destroy();
    }

    static function generateSessionKey($key){
        $append = $GLOBALS["config"]["appName"];
        $version = $GLOBALS["config"]["version"];
        return md5($key.$append.$version);
    }
}
?>