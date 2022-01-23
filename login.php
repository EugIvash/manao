<?php
require_once('./classes/Session.php');

$session = new Session();

setcookie("PHPSESSID", session_id());
setcookie("login", $_SESSION["login"]);

header('Location: ./index.php');