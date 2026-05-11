<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('user_app.php');

if(isset($_GET['email'])){
    checkEmailExists();
    exit;
}

if(existNameEmailAndPass()){
    cleanData();
    validateStringEmail();
    sanitizeEmail();
    matchPass();
    $senhaOriginal = trim($_POST['senha']);
    hashPassword();
    insertCredentialsIntoDB();
    recoverUserData($senhaOriginal);
    startSession();
}

function checkEmailExists(){
    global $mysqli;
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo json_encode(["exists" => false]);
        return;
    }

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    echo json_encode(["exists" => $stmt->num_rows > 0]);
    $stmt->close();
}

function existNameEmailAndPass(){
    return isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['senhaConfirm']);
}

function cleanData(){
    global $mysqli, $email, $senha, $nome, $senhaConfirm;
    $nome         = $mysqli->real_escape_string(trim($_POST['nome']));
    $email        = $mysqli->real_escape_string(trim($_POST['email']));
    $senha        = trim($_POST['senha']);
    $senhaConfirm = trim($_POST['senhaConfirm']);

    if(empty($nome) || empty($email) || empty($senha) || empty($senhaConfirm)) exit;
}

function validateStringEmail(){
    global $email;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) exit;
}

function sanitizeEmail(){
    global $email;
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
}

function matchPass(){
    global $senha, $senhaConfirm;
    if($senha !== $senhaConfirm) exit;
}

function hashPassword(){
    global $senha;
    $senha = password_hash($senha, PASSWORD_BCRYPT);
}

function insertCredentialsIntoDB(){
    global $mysqli, $email, $senha, $nome;
    $stmt = $mysqli->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);
    $stmt->execute();
    $stmt->close();
}

function recoverUserData($senhaOriginal){
    global $mysqli, $email, $usuario;
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if(!$usuario || !password_verify($senhaOriginal, $usuario['senha'])) exit;
}

function startSession(){
    global $usuario;
    $_SESSION['id']   = $usuario['id'];
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
        <div id="message">
            <p id="messageP"></p>
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