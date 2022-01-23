<?php

class Session {

    function __construct() {
        session_start();
    }

    function start($user){
        $_SESSION['login'] = $user["login"];
    }
    function destroy(){
        session_destroy();

        header('Location: ./index.php');
    }
}