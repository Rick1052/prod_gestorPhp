<?php
require_once 'pdo/User.php'; // Inclui a classe User

$user = new User();
$user->logout(); // Destrói a sessão do usuário

header('Location: login.php'); // Redireciona para a página de login
exit;
?>
