<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <?php
            if(isset($_COOKIE['login'])) {
                echo 'Привет, ' . $_COOKIE['login'] . "<br>"; 
            }
        ?>
    </div>
    <div>
        <?php
        if (isset($_COOKIE['login'])) {
        ?>
            <button onclick="logout()">Выход</button>
        <?php
        } else {
        ?>
            <button onclick="login()">Вход</button>
        <?php
        }
        ?>
    </div>

    <script>
        function login(){
            window.location.href = './signin.php';
        }
        function logout(){
            window.location.href = './logout.php';
        }
    </script>
</body>
</html>
