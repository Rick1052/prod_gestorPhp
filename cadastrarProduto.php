<?php
require_once 'Produto.php';
require_once 'db_connect.php'; // Conexão com o banco

$db = new Database();
$produto = new Produto($db);

$mensagem = "";
$produtoData = [
    'id' => '',
    'nome' => '',
    'unidade' => '',
    'preco' => '',
    'observacao' => '',
    'situacao' => '',
    'estoque' => '',
    'preco_custo' => '',
    'est_max' => '',
    'est_min' => '',
    'marca' => ''
];

// Verifica se há um ID na URL (modo edição)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $produtoData = $produto->buscarProdutoPorId($id);
    if (!is_array($produtoData)) {
        $mensagem = "Produto não encontrado.";
        $produtoData = [];
    }
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'];
    $unidade = $_POST['unidade'];
    $preco = $_POST['preco'];
    $observacao = $_POST['observacao'];
    $situacao = $_POST['situacao'];
    $estoque = $_POST['estoque'];
    $preco_custo = $_POST['preco_custo'];
    $est_max = $_POST['est_max'];
    $est_min = $_POST['est_min'];
    $marca = $_POST['marca'];

    if ($id) {
        // Atualiza o produto existente
        $mensagem = $produto->editarProduto($id, $nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca);
    } else {
        // Cadastra um novo produto
        $mensagem = $produto->cadastrarProduto($nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? "Editar Produto" : "Cadastrar Produto"; ?></title>
</head>
<body>
    <h2><?php echo isset($_GET['id']) ? "Editar Produto" : "Cadastrar Novo Produto"; ?></h2>
    
    <?php if (!empty($mensagem)): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produtoData['id'] ?? ''); ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($produtoData['nome'] ?? ''); ?>" required><br>

        <label>Unidade:</label>
        <input type="text" name="unidade" value="<?php echo htmlspecialchars($produtoData['unidade'] ?? ''); ?>" required><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?php echo htmlspecialchars($produtoData['preco'] ?? ''); ?>" required><br>

        <label>Observação:</label>
        <textarea name="observacao"><?php echo htmlspecialchars($produtoData['observacao'] ?? ''); ?></textarea><br>

        <label>Situação:</label>
        <select name="situacao">
            <option value="ativo" <?php echo ($produtoData['situacao'] ?? '') == 'ativo' ? 'selected' : ''; ?>>Ativo</option>
            <option value="inativo" <?php echo ($produtoData['situacao'] ?? '') == 'inativo' ? 'selected' : ''; ?>>Inativo</option>
        </select><br>

        <label>Estoque:</label>
        <input type="number" name="estoque" value="<?php echo htmlspecialchars($produtoData['estoque'] ?? ''); ?>" required><br>

        <label>Preço de Custo:</label>
        <input type="number" step="0.01" name="preco_custo" value="<?php echo htmlspecialchars($produtoData['preco_custo'] ?? ''); ?>" required><br>

        <label>Estoque Máximo:</label>
        <input type="number" name="est_max" value="<?php echo htmlspecialchars($produtoData['est_max'] ?? ''); ?>" required><br>

        <label>Estoque Mínimo:</label>
        <input type="number" name="est_min" value="<?php echo htmlspecialchars($produtoData['est_min'] ?? ''); ?>" required><br>

        <label>Marca:</label>
        <input type="text" name="marca" value="<?php echo htmlspecialchars($produtoData['marca'] ?? ''); ?>" required><br>

        <button type="submit"><?php echo isset($_GET['id']) ? "Atualizar Produto" : "Cadastrar Produto"; ?></button>
    </form>
</body>
</html>
