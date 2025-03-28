<?php
require_once '../pdo/produto.php';
require_once '../database/db_connect.php'; // Conexão com o banco
require_once '../pdo/User.php'; 

$user = new User();

if (!$user->isLoggedIn()) {
    header('Location: /php/gestor_pro/login.php'); // Redireciona se não estiver logado
    exit;
}

$db = new Database();
$produto = new Produto($db);

$mensagem = "";
$erros = [];
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

// Verifica se há um ID na URL
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
    $nome = trim($_POST['nome']);
    $unidade = trim($_POST['unidade']);
    $preco = $_POST['preco'];
    $observacao = trim($_POST['observacao']);
    $situacao = $_POST['situacao'];
    $estoque = $_POST['estoque'];
    $preco_custo = $_POST['preco_custo'];
    $est_max = $_POST['est_max'];
    $est_min = $_POST['est_min'];
    $marca = trim($_POST['marca']);

    // Validações
    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    }
    if (empty($unidade)) {
        $erros[] = "O campo Unidade é obrigatório.";
    }
    if (!is_numeric($preco) || $preco < 0) {
        $erros[] = "O campo Preço deve ser um número válido e positivo.";
    }
    if (!is_numeric($estoque) || $estoque < 0) {
        $erros[] = "O campo Estoque deve ser um número válido e positivo.";
    }
    if (!is_numeric($preco_custo) || $preco_custo < 0) {
        $erros[] = "O campo Preço de Custo deve ser um número válido e positivo.";
    }
    if (!is_numeric($est_max) || $est_max < 0) {
        $erros[] = "O campo Estoque Máximo deve ser um número válido e positivo.";
    }
    if (!is_numeric($est_min) || $est_min < 0) {
        $erros[] = "O campo Estoque Mínimo deve ser um número válido e positivo.";
    }
    if (empty($marca)) {
        $erros[] = "O campo Marca é obrigatório.";
    }

    // Se não houver erros, insere ou atualiza o produto
    if (empty($erros)) {
        if ($id) {
            $mensagem = $produto->editarProduto($id, $nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca);
        } else {
            $mensagem = $produto->cadastrarProduto($nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_GET['id']) ? "Editar Produto" : "Cadastrar Produto"; ?></title>
    <link rel="stylesheet" href="../assets/style/cadProd.css">
</head>

<body>
    <h2><?php echo isset($_GET['id']) ? "Editar Produto" : "Cadastrar Novo Produto"; ?></h2>

    <?php if (!empty($mensagem)): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <?php if (!empty($erros)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?php echo $erro; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($produtoData['id'] ?? ''); ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($produtoData['nome'] ?? ''); ?>" required><br>

        <label>Unidade:</label>
        <select name="unidade" required>
            <option value="UN" <?php echo ($produtoData['unidade'] ?? '') == 'UN' ? 'selected' : ''; ?>>Unidade (UN)
            </option>
            <option value="MT" <?php echo ($produtoData['unidade'] ?? '') == 'MT' ? 'selected' : ''; ?>>Metro (MT)
            </option>
            <option value="CJ" <?php echo ($produtoData['unidade'] ?? '') == 'CJ' ? 'selected' : ''; ?>>Conjunto (CJ)
            </option>
            <option value="PC" <?php echo ($produtoData['unidade'] ?? '') == 'PC' ? 'selected' : ''; ?>>Peça (PC)</option>
        </select>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco"
            value="<?php echo htmlspecialchars($produtoData['preco'] ?? ''); ?>" required><br>

        <label>Observação:</label>
        <textarea name="observacao"><?php echo htmlspecialchars($produtoData['observacao'] ?? ''); ?></textarea><br>

        <label>Situação:</label>
        <select name="situacao">
            <option value="ativo" <?php echo ($produtoData['situacao'] ?? '') == 'ativo' ? 'selected' : ''; ?>>Ativo
            </option>
            <option value="inativo" <?php echo ($produtoData['situacao'] ?? '') == 'inativo' ? 'selected' : ''; ?>>Inativo
            </option>
        </select><br>

        <label>Estoque:</label>
        <input type="number" name="estoque" value="<?php echo htmlspecialchars($produtoData['estoque'] ?? ''); ?>"
            required><br>

        <label>Preço de Custo:</label>
        <input type="number" step="0.01" name="preco_custo"
            value="<?php echo htmlspecialchars($produtoData['preco_custo'] ?? ''); ?>" required><br>

        <label>Estoque Máximo:</label>
        <input type="number" name="est_max" value="<?php echo htmlspecialchars($produtoData['est_max'] ?? ''); ?>"
            required><br>

        <label>Estoque Mínimo:</label>
        <input type="number" name="est_min" value="<?php echo htmlspecialchars($produtoData['est_min'] ?? ''); ?>"
            required><br>

        <label>Marca:</label>
        <input type="text" name="marca" value="<?php echo htmlspecialchars($produtoData['marca'] ?? ''); ?>"
            required><br>

        <button type="submit"><?php echo isset($_GET['id']) ? "Atualizar Produto" : "Cadastrar Produto"; ?></button>
    </form>
</body>

</html>