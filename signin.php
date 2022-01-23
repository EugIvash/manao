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
  <title>Sign in to site</title>
  <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
  <form id="login_form" method="post">
    <div class="container">
      <label for="login"><b>Логин</b></label>
      <input type="text" placeholder="Введите логи" name="login" required>
      <span id="loginErr"></span>
      <br>
      <label for="psw"><b>Пароль</b></label>
      <input type="password" placeholder="Введите пароль" name="psw" required>
      <span id="pswErr"></span>
      <br>
      <button type="submit">Войти</button>
    </div>
    <br>
    <div class="container signup">
      <p>Впервые на сайте? <a href="./signup.php">Регистрация</a>.</p>
    </div>
  </form>

  <script>
    const form = document.getElementById("login_form");

    const loginErr = document.querySelector('#loginErr');
    const pswErr = document.querySelector('#pswErr');

    form.addEventListener("submit", returnData);

    function printData(data){

      loginErr.innerHTML = "";
      pswErr.innerHTML = "";

      if('loginErr' in data){
        loginErr.textContent = data['loginErr'];
      }
      if('pswErr' in data){
        pswErr.textContent = data['pswErr'];
      }
    }

    function returnData(e){
      e.preventDefault();
      fetch("./actions/login_action.php", {
        method: "POST",
        body: new FormData(form),
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