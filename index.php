<?php

session_start();
include('user_app.php');

if(existNameEmailAndPass()){
    verifycharacters();
    cleanData();
    matchPass();
    insertCredentialsIntoDB();
    recoverUserData();
    verifySession();
    startSession();
}

function existNameEmailAndPass(){
    return isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['senhaConfirm']);
}

function verifycharacters(){
    if(nameIsNull() || emailIsNull() || passIsNull() || passConfirmIsNull()){
        exit;
    }
}

function nameIsNull(){
    return empty($_POST['nome']);
}

function emailIsNull(){
    return empty($_POST['email']);
}

function passIsNull(){
    return empty($_POST['senha']);
}

function passConfirmIsNull(){
    return empty($_POST['senhaConfirm']);
}


function cleanData(){
    global $mysqli, $email, $senha, $nome, $senhaConfirm;
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);
    $senhaConfirm = $mysqli->real_escape_string($_POST['senhaConfirm']);
}

function matchPass(){
    global $senha, $senhaConfirm;
    if($senha != $senhaConfirm){
        exit;
    }
}

function insertCredentialsIntoDB(){
    global $mysqli, $email, $senha, $nome, $sqlQuery;

    $sqlCode = "INSERT INTO users (nome,email,senha) VALUES ('$nome','$email','$senha')";
    $mysqli->query($sqlCode);
}

function recoverUserData(){
    global $mysqli, $sqlQuery, $usuario, $email, $senha;

    $sqlQuery = $mysqli->query("SELECT * FROM users WHERE email='$email' AND senha='$senha'");
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
    header("Location: logIn.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <form action="index.php" method="POST" id="createAccount">
        <h1>Crie sua conta</h1>
        <div class="inputBox">
            <input type="text" name="nome" id="inputName" required>
            <label for="nome" id="labelNome">Nome de Usuário</label>
        </div>
        <div class="inputBox">
            <input type="email" name="email" id="inputEmail" required>
            <label for="email" id="labelEmail">Email</label>
        </div>
        <div class="inputBox">
            <input type="password" name="senha" id="inputPassword" required>
            <label for="senha" id="labelSenha">Senha</label>
        </div>
        <div class="inputBox">
            <input type="password" name="senhaConfirm" id="inputAuthPassword" required>
            <label for="senhaConfirm" id="labelSenhaConfirm">Confirme sua senha</label>
        </div>
        <div id="buttonElinkCreateAccount">
            <button type="submit" id="btnSend">Cadastrar</button>
        </div>
    </form>
    <section>
        <div id="groupLogin">
            <h2>Já possui uma conta?</h2>
            <a href="logIn.php">Faça LogIn</a>
        </div>
    </section>
    <script src="JavaScript/scriptCad.js"></script>
</body>
</html>