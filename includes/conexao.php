<?php
// Conexão com o banco de dados
// Usando porta 3307
// No Docker, use o nome do serviço como host e as credenciais do docker-compose
$host = 'db';
$user = 'user';
$pass = 'password';
$db = 'pets_db';
$port = 3306;
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}
?>
