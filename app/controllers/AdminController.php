<?php

class AdminController extends Controller
{

    public function index()
    {
        $data = [];
        if (Common::isLoggedIn()) {
            Url::redir("admin/home");
        } else {
            if (Url::post("username") && Url::post("password")) {
                if ($user = Admins::auth(Url::post("username"), Url::post("password"))) {
                    Session::set("id", $user[0]["id"]);
                    Session::set("username", $user[0]["username"]);
                    Session::set("password", $user[0]["password"]);
                    Session::set("fName", $user[0]["fName"]);
                    Session::set("lName", $user[0]["lName"]);
                    Session::set("deleted", $user[0]["deleted"]);
                    Url::redir("admin/home");
                }

                $data = ['error' => "Username or Password Incorrect."];

            }
        }
        Load::view("admin/login", $data);
    }

    public function home()
    {
        if (!Common::isLoggedIn()){
            Load::view("admin/login");

        }
        Load::view('admin/home');

    }

    public function logout()
    {
        Session::endSession();
        Url::redir("/");
    }
}

?>