<?php
require_once('../classes/RegistrationForm.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

$registr_form = new RegistrationForm($_POST["login"], $_POST["psw"], $_POST["pswRepeat"], $_POST["email"], $_POST["name"]);
$registr_form->checkForm();

echo json_encode($registr_form->getErrorData());

} else {
    echo('Hasta la vista, baby');
}