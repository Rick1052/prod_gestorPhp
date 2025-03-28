<?php
require_once 'pdo/User.php'; // Inclui a classe User

$errorMessage = ''; // Inicializa a variável de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = new User();
    $result = $user->register($username, $email, $password); // Registra o usuário
    
    if ($result !== true) { // Caso o resultado não seja verdadeiro, ocorre um erro
        $errorMessage = $result; // Atribui a mensagem de erro
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor Pro - Cadastro</title>
    <link rel="stylesheet" href="assets/style/register.css">
</head>

<body>

    <div class="login-container">
        <h2>Registrar Conta</h2>

        <!-- Exibe a mensagem de erro, se houver -->
        <?php if ($errorMessage): ?>
            <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form method="post" class="register-form">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>

        <!-- Botão de voltar ao login -->
        <a href="login.php" class="back-to-login">Voltar ao Login</a>
    </div>

</body>

</html>
