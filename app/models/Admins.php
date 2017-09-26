<?php
class Admins extends Database {

    static public function auth($username, $password){
       return self::select( "SELECT * FROM admins WHERE username='%s' and password='%s' and deleted='%s'", [$username,$password,0]);
    }
}
?>