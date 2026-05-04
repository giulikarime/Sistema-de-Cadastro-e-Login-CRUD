<?php

include('user_app.php');

if(existEmailAndPass()){
    verifyChacters();
    cleanData();
    conectMySQL();
    countUsersInDB();
    verifySession();
    startSession();
}

function existEmailAndPass(){
    return isset($_POST['email']) && isset($_POST['senha']);
}

function verifyChacters(){
    if(charactersIsNull()){
        exit;
    }                                                                                                                                                                            
}

function charactersIsNull(){
    return emailNull() || passNull();
}

function emailNull(){
    return strlen($_POST['email']) == 0;
}

function passNull(){
    return strlen($_POST['senha']) == 0;
}


function cleanData(){
    global $mysqli, $email, $senha;
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);
}

function conectMySQL(){
    global $mysqli, $email, $senha, $sqlQuery;
    $sqlCode = "SELECT * FROM users WHERE email = '$email' AND senha = '$senha'";
    $sqlQuery = $mysqli->query($sqlCode) or die("Falha na execução: " . $mysqli->error);
}

function countUsersInDB(){
    global $sqlQuery;
    $userExistsWithCredentials = $sqlQuery->num_rows;
    if($userExistsWithCredentials == 1){
        recoverUserData();
    } else {
        exit;
    }
}

function recoverUserData(){
    global $sqlQuery, $usuario;
    $usuario = $sqlQuery->fetch_assoc();
}

function verifySession(){
    if(!isset($_SESSION)){
        session_start();
    }
}

function startSession(){
    global $usuario;
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    header("Location: startSession.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <form action="logIn.php" method="POST" id="createAccount">
        <h1>Abra sua conta</h1>
        <div class="inputBox">
            <input type="email" name="email" id="inputEmail" required>
            <label for="email" id="labelEmail">Email</label>
        </div>
        <div class="inputBox">
            <input type="password" name="senha" id="inputPassword" required>
            <label for="senha" id="labelSenha">Senha</label>
        </div>
        <div id="buttonElinkCreateAccount">
            <button type="submit" id="btnSend">Enviar</button>
        </div>
    </form>
    <section>
        <div id="groupLogin">
            <h2>Não possui uma conta ainda?</h2>
            <a href="index.php">Cadastre-se</a>
        </div>
    </section>
    <script src="JavaScript/scriptLogin.js"></script>
</body>
</html>