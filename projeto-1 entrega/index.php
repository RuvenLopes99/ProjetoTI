<?php

session_start();

//guarda os utilizadores e passwords para a verificação do login

$username1Registado ="ruven";
$password1Registado ="123";
$username2Registado = "carolina";
$password2Registado = "123";
$username3Registado = "admin";
$password3Registado = "admin";


$_SESSION["username"] = "username";
$_SESSION["password"] = "password";

if (isset($_POST['username']) && isset($_POST['password'])){ //confirma se as variáveis contêm alguma informação ou seja != null
    $username=$_POST['username'];        //as variaveis passam a ser iguais ás inserdias pelo utilizador
    $password=$_POST['password'];

    if(($username == $username1Registado && $password == $password1Registado) || ($username == $username2Registado && $password == $password2Registado) || ($username == $username3Registado && $password == $password3Registado)){        //confirma se o username e a password são iguais às do registo, confirmando se a autenticação é ou não bem sucedida
        echo "Autenticação bem sucedida (login)";
        $_SESSION["username"]=$_POST['username'];
        header( "Location: dashboard.php");
    }else {
        echo "Autenticação falhada";
    }
}

?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device=width, initial-scale=1">
    <title>Estacionamento - Login</title>
    <link rel="icon" type="image/x-icon" href="imagens/square-parking-solid.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container login">
        <div class="row justify-content-center">
            <form class="tiform" method="POST">
                <div><img class="logo-estg-login" src="imagens/logoipl.jpeg" alt="Logotipo IPL"></div>
                <br>
                <br>
                <div class="justify-content-center">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Insira o seu username" required="required">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Insira a sua password" required="required">
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary">Submeter</button></div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>