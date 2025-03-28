<?php
require_once '../pdo/produto.php';
require_once '../pdo/User.php'; 

$user = new User();

if (!$user->isLoggedIn()) {
    header('Location: /php/gestor_pro/login.php'); // Redireciona se não estiver logado
    exit;
}

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
    <link rel="stylesheet" href="../assets/style/listProd.css">
</head>

<body>

    <div class="mensagem">
        <?php if (isset($_GET['mensagem'])): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($_GET['mensagem']) ?></p>
        <?php endif; ?>
    </div>

    <div class="containerButton">
        <div class="button">
            <button><a href="cadastrarProduto.php">Cadastrar Produto</a></button><br />

            <button onclick="window.location.href='exportarProdutos.php'">Exportar Produtos (TXT)</button>
        </div>

    </div>


    <div class="tableProd">
        <table>
            <tr>
                <th></th>
                <th>Nome</th>
                <th>Estoque</th>
                <th>Preço</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>

            <?php foreach ($produtos as $p): ?>
                <tr>

                    <td>
                        <?= $p['id'] ?>
                    </td>
                    <td>
                        <?= $p['nome'] ?>
                    </td>

                    <td>

                        <?= $p['estoque'] ?>
                    </td>

                    <td>

                        R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                    </td>

                    <td>

                        <button id="btnGerEst" onclick="openModal(<?= $p['id'] ?>, <?= $p['estoque'] ?>)">Gerenciar
                            Estoque</button>
                    </td>

                    <td>
                        <a href="cadastrarProduto.php?id=<?= $p['id'] ?>"><img src="../assets/icons/editar.png" width="30px"
                                alt=""></a>

                    </td>

                    <td>
                        <a href='deletarProduto.php?id=<?= $p['id'] ?>'
                            onclick='return confirm("Tem certeza que deseja excluir este produto?")'>
                            <img src="../assets/icons/excluir.png" width="30px" alt="">
                        </a>

                    </td>

                </tr>
            <?php endforeach; ?>

        </table>
    </div>



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
            const modal = document.getElementById("estoqueModal");
            const modalContent = document.querySelector(".modal-content");

            document.getElementById("produtoId").value = id;
            document.getElementById("estoque").value = "";

            modal.style.display = "flex"; // Exibe o modal
            setTimeout(() => {
                modal.classList.add("show"); // Aplica animação de entrada
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("estoqueModal");
            modal.classList.remove("show"); // Remove animação

            setTimeout(() => {
                modal.style.display = "none"; // Aguarda a animação antes de fechar
            }, 300);
        }

        window.onclick = function (event) {
            const modal = document.getElementById("estoqueModal");
            if (event.target === modal) {
                closeModal();
            }
        }


    </script>

</body>

</html>