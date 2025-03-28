<?php
require_once '../pdo/produto.php';
require_once '../database/db_connect.php';
require_once '../pdo/User.php'; 

$user = new User();

if (!$user->isLoggedIn()) {
    header('Location: /php/gestor_pro/login.php'); // Redireciona se não estiver logado
    exit;
}

$db = new Database();
$produto = new Produto($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $acao = $_POST['acao'];
    $estoque = intval($_POST['estoque']);

    $mensagem = "";

    switch ($acao) {
        case 'aumentar':
            $mensagem = $produto->aumentarEstoque($id, $estoque);
            break;
        case 'diminuir':
            $mensagem = $produto->diminuirEstoque($id, $estoque);
            break;
        case 'balanco':
            $mensagem = $produto->fazerBalanco($id, $estoque);
            break;
        default:
            $mensagem = "Ação inválida!";
    }

    // Redireciona para a página principal com mensagem de status
    header("Location: listarProdutos.php?mensagem=" . urlencode($mensagem));
    exit;
}
?>
