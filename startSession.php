<?php

include('protect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Usuário</title>
    <link rel="stylesheet" href="CSS/startSession.css">
</head>
<body>
    <main>
        <h1>Bem vindo(a), <?php echo $_SESSION['nome']; ?></h1>
        <p id='text'>Obrigada por acessar este site!</p>
        <button id="btnSend"><p>Sair</p> <div id="branco" ></div></button>
    </main>
    <script src="JavaScript/session.js"></script>
</body>
</html>