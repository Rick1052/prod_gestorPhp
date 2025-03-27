<?php
require_once 'produto.php';
require_once 'db_connect.php';

$db = new Database();
$produto = new Produto($db);

// Buscar todos os produtos
$produtos = $produto->listarProdutos();

// Nome do arquivo para download
$filename = "produtos_" . date("Ymd_His") . ".txt";

// Criar o conteúdo do arquivo
$conteudo = "ID | Nome | Estoque | Preço\n";
$conteudo .= str_repeat("=", 50) . "\n";

foreach ($produtos as $p) {
    $linha = "{$p['id']} | {$p['nome']} | {$p['estoque']} | R$" . number_format($p['preco'], 2, ',', '.');
    $conteudo .= $linha . "\n";
}

// Definir os headers para download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($conteudo));

// Enviar o conteúdo
echo $conteudo;
exit;
?>
