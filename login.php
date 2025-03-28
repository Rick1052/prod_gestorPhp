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
        $errorMessage = "Credenciais inválidas!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor Pro - Login</title>
    <link rel="stylesheet" href="assets/style/login.css">
</head>

<body>

    <div class="login-container">
        
        <?php if (isset($errorMessage)): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <h2>Login</h2>

            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>

            <!-- Link para página de registro -->
            <a href="register.php" class="register-link">Registrar-se</a>
        </form>
    </div>

</body>

</html>
