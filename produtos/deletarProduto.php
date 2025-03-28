<?php
require_once '../pdo/produto.php';

require_once '../pdo/User.php'; 

$user = new User();

if (!$user->isLoggedIn()) {
    header('Location: /php/gestor_pro/login.php'); // Redireciona se não estiver logado
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = new Database();
    $produto = new Produto($db);

    $mensagem = $produto->deletarProduto($_GET['id']);
}
?>
