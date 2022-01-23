<?php
require_once('../classes/CRUD.php');
require_once('../classes/Session.php');

class RegistrationForm {
    private $login;
    private $psw;
    private $pswRepeat;
    private $email;
    private $name;
    private $error_data = [];

    function __construct($login, $psw, $pswRepeat, $email, $name){
        $this->login = trim(stripslashes(htmlspecialchars($login)));
        $this->psw = trim(stripslashes(htmlspecialchars($psw)));
        $this->pswRepeat = trim(stripslashes(htmlspecialchars($pswRepeat)));
        $this->email = trim(stripslashes(htmlspecialchars($email)));
        $this->name = trim(stripslashes(htmlspecialchars($name)));
    }

    function getUserByLogin(){
        $crud = new CRUD();
        $users = $crud->read('users');

        foreach ($users as $user) {
            if ($user["login"] == $this->login ) {
                return $user;
            }
        }

        return null;
    }

    function getUserByEmail(){
        $crud = new CRUD();
        $users = $crud->read('users');

        foreach ($users as $user) {
            if ($user["email"] == $this->email ) {
                return $user;
            }
        }

        return null;
    }

    function checkForm(){
        
        if (empty($this->login)) {
            $loginErr = "Логин обязательное поле";
            $this->error_data["loginErr"] = $loginErr;
        } else {
            if (!preg_match("/^[a-zA-Z]{6,}$/", $this->login)) {
                $loginErr = "Логин может состоять только из букв более 6 символов";
                $this->error_data["loginErr"] = $loginErr;
            }
        }
    
        if (empty($this->psw)) {
            $pswErr = "Пароль обязательное поле";
            $this->error_data["pswErr"] = $pswErr;
        } else {
            if (!preg_match("/^[0-9a-zA-Z]{6,}$/", $this->psw)) {
                $pswErr = "Пароль может состоять только из букв и цифр более 6 символов";
                $this->error_data["pswErr"] = $pswErr;
            }
        }
    
        if (empty($this->pswRepeat)) {
            $pswRepeat = "Поле обязательное для заполнения";
            $this->error_data["pswRepeatErr"] = $pswRepeat;
        }  else if($this->psw != $this->pswRepeat) {
            $pswRepeatErr = "Пароль не совпадает";
            $this->error_data["pswRepeatErr"] = $pswRepeatErr;
        }
    
        if (empty($this->name)) {
            $nameErr = "Имя обязательно";
            $this->error_data["nameErr"] = $nameErr;
        } else {
            if (!preg_match("/^[a-zA-Z]{2}$/", $this->name)) {
                $nameErr = "Имя должно быть только 2 символа и только буквы";
                $this->error_data["nameErr"] = $nameErr;
            }
        }
    
        if (empty($this->email)) {
            $emailErr = "Email обязательно";
            $this->error_data["emailErr"] = $emailErr;
        } else {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Неверный формат электронной почты";
                $this->error_data["emailErr"] = $emailErr;
            }
        }

        if (empty($this->getErrorData()["loginErr"])) {
            $user = $this->getUserByLogin();
            if (isset($user)) {
                $this->error_data["loginErr"] = "Такой пользователь уже существует";
            }
        }
        if (empty($this->getErrorData()["emailErr"])) {
            $user = $this->getUserByEmail();
            if (isset($user)) {
                $this->error_data["emailErr"] = "Такой email уже зарегестрирован";
            }
        }

        if (empty($this->getErrorData())) {
            $register_data = [];
            $crud = new CRUD();

            $salt = $this->generateSalt();
            $hash = md5($salt . $this->psw);
        
            $register_data["login"] = $this->login;
            $register_data["password"] = $hash;
            $register_data["salt"] = $salt;
            $register_data["name"] = $this->name;
            $register_data["email"] = $this->email;

            $crud->create('users', $register_data);

            $session = new Session();
            $session->start($register_data);
        }
    }

    function getErrorData() {
        return $this->error_data;
    }

    function generateSalt()
	{
		$salt = '';
		$saltLength = 8; // длина соли
		
		for($i = 0; $i < $saltLength; $i++) {
			$salt .= chr(mt_rand(97, 122)); // символ из ASCII-table
		}
		
		return $salt;
	}
}