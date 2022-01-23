<?php
require_once('./classes/Session.php');

    $session = new Session();
    $session->destroy();
    setcookie("PHPSESSID", "", -1);
    setcookie("login", "", -1);