<?php
// Conexão com o banco de dados
// Usando porta 3307
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pets_trab';
$port = 3307;
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}
?>
