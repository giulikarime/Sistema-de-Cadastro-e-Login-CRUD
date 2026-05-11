<?php
session_start();
include('user_app.php');

if(existEmailAndPass()){
    verifyCharacters();
    cleanData();
    $usuario = findUserByEmail();
    verifyCredentials($usuario);
    startSession($usuario);
}

function existEmailAndPass(){
    return isset($_POST['email']) && isset($_POST['senha']);
}

function verifyCharacters(){
    if(empty($_POST['email']) || empty($_POST['senha'])){
        returnError("Preencha todos os campos.");
    }
}

function cleanData(){
    global $mysqli, $email, $senha;
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $senha = trim($_POST['senha']);
}

function findUserByEmail(){
    global $mysqli, $email;

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function verifyCredentials($usuario){
    global $senha;

    if(!$usuario || !password_verify($senha, $usuario['senha'])){
        returnError("Email ou senha incorretos.");
    }
}

function startSession($usuario){
    $_SESSION['id']   = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    echo json_encode(["success" => true]);
    exit;
}

function returnError($message){
    echo json_encode(["success" => false, "message" => $message]);
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
        <div id="message">
            <p id="messageP"></p>
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