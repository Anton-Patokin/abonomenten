<?php
class  MainController extends Controller implements ControllerInterface{
    function index(){
        Load::view("/main/index");
    }

    function handlebars(){
       return load::view("/main/handlebar");
    }
}
?>