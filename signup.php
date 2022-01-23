<?php 
session_start();
if (isset($_SESSION['login'])) {
  header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up to site</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <form id="register_form" method="post">
        <div class="container">
            <label for="login"><b>Логин*</b></label>
            <input type="text" placeholder="Введите логин" name="login" id="login" required>
            <span id="loginErr"></span>
            <br>
            <label for="psw"><b>Пароль*</b></label>
            <input type="password" placeholder="Введите пароль" name="psw" id="psw" required>
            <span id="pswErr"></span>
            <br>
            <label for="psw-repeat"><b>Повторите пароль*</b></label>
            <input type="password" placeholder="Повторите пароль" name="pswRepeat" id="pswRepeat" required>
            <span id="pswRepeatErr"></span>
            <br>
            <label for="email"><b>Email*</b></label>
            <input type="text" placeholder="Введите Email" name="email" id="email" required>
            <span id="emailErr"></span>
            <br>
            <label for="name"><b>Имя*</b></label>
            <input type="text" placeholder="Введите имя" name="name" id="name" required>
            <span id="nameErr"></span>
            <br>
            <button type="submit" class="registerbtn">Зарегистрироваться</button>
        </div>

        <div class="container signin">
            <p>Уже существует учетная запись? <a href="./signin.php">Войти</a>.</p>
        </div>
    </form>

    <script>
        const form = document.getElementById("register_form");

        const loginErr = document.querySelector('#loginErr');
        const pswErr = document.querySelector('#pswErr');
        const pswRepeatErr = document.querySelector('#pswRepeatErr');
        const emailErr = document.querySelector('#emailErr');
        const nameErr = document.querySelector('#nameErr');

        form.addEventListener("submit", returnData);

        

        function printData(data){

            loginErr.innerHTML = "";
            pswErr.innerHTML = "";
            pswRepeatErr.innerHTML = "";
            emailErr.innerHTML = "";
            nameErr.innerHTML = "";

            if('loginErr' in data){
                loginErr.textContent = data['loginErr'];
            }
            if('pswErr' in data){
                pswErr.textContent = data['pswErr'];
            }
            if('pswRepeatErr' in data){
                pswRepeatErr.textContent = data['pswRepeatErr'];
            }
            if('emailErr' in data){
                emailErr.textContent = data['emailErr'];
            }
            if('nameErr' in data){
                nameErr.textContent = data['nameErr'];
            }
        }
        
        function returnData(e){

            e.preventDefault();

            fetch("./actions/register_action.php", {
                method: "POST",
                body: new FormData(document.forms.register_form),
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
                
            })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if(data.length == 0){
                    setTimeout(function () {
                        window.location.href = "./login.php";
                    }, 2000);
                }
                printData(data);
            });
        }  
    </script>
</body>
</html>