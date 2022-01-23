<?php
require_once('../classes/CRUD.php');
require_once('../classes/Session.php');

class LoginForm {
    private $login;
    private $psw;
    private $error_data = [];

    function __construct($login, $psw){
        $this->login = trim(stripslashes(htmlspecialchars($login)));
        $this->psw = trim(stripslashes(htmlspecialchars($psw)));
    }

    function existsUser(){
        $crud = new CRUD();
        $users = $crud->read('users');

        foreach ($users as $user) {
            if ($user["login"] == $this->login ) {
                return $user;
            }
        }

        return null;
    }

    function checkForm(){
        
        $user = $this->existsUser();

        if (isset($user)) {
            $salt = $user['salt'];
            $hash = $user["password"];

            $password = md5($salt . $this->psw);

            if ($hash == $password) {
                $session = new Session();
                $session->start($user);
            } else {
                $this->error_data["pswErr"] = "Пароль введен неверно";
            }
        } else {
            $this->error_data["loginErr"] = "Пользователь не найден";
        }
    }

    function getErrorData() {
        return $this->error_data;
    }
}