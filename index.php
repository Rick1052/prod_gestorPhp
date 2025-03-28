<?php
require_once 'pdo/User.php'; // Inclui a classe User

$user = new User();

if (!$user->isLoggedIn()) {
    header('Location: login.php'); // Redireciona se não estiver logado
    exit;
}

$userInfo = $user->getUserInfo(); // Obtém as informações do usuário logado
echo "Bem-vindo, " . htmlspecialchars($userInfo['username']) . "!";
echo '<br><a href="logout.php">Sair</a>';
?>
