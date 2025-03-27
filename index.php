<?php
require_once 'produto.php';

$db = new Database();
$produto = new Produto($db);

$produtos = $produto->listarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Gestor Pro</title>
    <link rel="stylesheet" href="style/listProd.css">
</head>

<body>

    <div class="mensagem">
        <?php if (isset($_GET['mensagem'])): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($_GET['mensagem']) ?></p>
        <?php endif; ?>
    </div>
            
    <div class="button">
        <button><a href="cadastrarProduto.php">Cadastrar Produto</a></button><br />

        <button onclick="window.location.href='exportarProdutos.php'">Exportar Produtos (TXT)</button>
    </div>


    <?php foreach ($produtos as $p): ?>
        <p>
            ID: <?= $p['id'] ?> - Nome: <?= $p['nome'] ?> - Estoque: <?= $p['estoque'] ?> - Preço:
            R$<?= number_format($p['preco'], 2, ',', '.') ?>
            <button onclick="openModal(<?= $p['id'] ?>, <?= $p['estoque'] ?>)">Gerenciar Estoque</button>
            <a href="cadastrarProduto.php?id=<?= $p['id'] ?>"><button>Editar</button></a>
            <a href='deletarProduto.php?id=<?= $p['id'] ?>'
                onclick='return confirm("Tem certeza que deseja excluir este produto?")'>
                <button>Deletar</button>
            </a>
    <?php endforeach; ?>

    <div id="estoqueModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Gerenciar Estoque</h2>
            <form id="estoqueForm" action="atualizarEstoque.php" method="post">
                <input type="hidden" id="produtoId" name="id">

                <label for="tipoAcao">Escolha uma ação:</label>
                <select id="tipoAcao" name="acao" required>
                    <option value="aumentar">Aumentar Estoque</option>
                    <option value="diminuir">Diminuir Estoque</option>
                    <option value="balanco">Fazer Balanço</option>
                </select><br />

                <label for="estoque">Estoque:</label>
                <input type="number" id="estoque" name="estoque" required>

                <button type="submit">Atualizar</button>
            </form>

        </div>
    </div>

    <script>
        function openModal(id, estoque) {
            document.getElementById("produtoId").value = id;
            document.getElementById("estoque").value = "";
            document.getElementById("estoqueModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("estoqueModal").style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === document.getElementById("estoqueModal")) {
                closeModal();
            }
        }

    </script>

</body>

</html>