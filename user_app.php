<?php

$host = 'localhost';
$user = 'new_app_user';
$pass = 'bnp\s8XDB32o';
$database = 'cadastro';

$mysqli = new mysqli($host,$user,$pass,$database);

if ($mysqli->connect_errno) {
    die("Falha na conexão: " . $mysqli->connect_error);
}
?>