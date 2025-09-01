<?php
session_start();
session_destroy();
header('Location: login.php');
exit();
// include 'includes/header.php'; // Não incluir header.php aqui
?>
