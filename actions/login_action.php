<?php
require_once('../classes/LoginForm.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    
    $login_form = new LoginForm($_POST["login"], $_POST["psw"]);
    $login_form->checkForm();

    echo json_encode($login_form->getErrorData());

} else {
    echo('Hasta la vista, baby');
}