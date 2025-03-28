<?php
require_once 'pdo/User.php'; // Inclui a classe User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = new User();
    $result = $user->register($username, $email, $password); // Registra o usuário
    echo $result;
}
?>

<form method="post">
    <input type="text" name="username" placeholder="Usuário" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>
