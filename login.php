<?php
require_once 'pdo/User.php'; // Inclui a classe User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $user = new User();
    $isLoggedIn = $user->login($email, $password); // Tenta fazer login

    if ($isLoggedIn) {
        header('Location: produtos/listarProdutos.php'); // Redireciona para o painel de controle
    } else {
        echo "Credenciais inválidas!";
    }
}
?>

<form method="post">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
