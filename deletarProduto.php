<?php
require_once 'produto.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = new Database();
    $produto = new Produto($db);

    $mensagem = $produto->deletarProduto($_GET['id']);
}

// Redireciona para a listagem após excluir
header("Location: index.php");
exit;
?>
