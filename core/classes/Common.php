<?php


class Common{
    static public function isLoggedIn(){
        $check = ["id", "username",['password',"id",['username']], "fName", ["lNameee"]];

        return (Session::check( "username"))? true : false;
    }
}
?>