<?php
require_once 'produto.php';
require_once 'db_connect.php';

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
    header("Location: index.php?mensagem=" . urlencode($mensagem));
    exit;
}
?>
