<?php

require_once 'db_connect.php'; // Importa a conexão com o banco

class Produto
{
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db->pdo;
    }

    // Listar todos os produtos
    public function listarProdutos()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM produto ORDER BY id ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Erro ao buscar produto: " . $e->getMessage();
        }
    }

    // Buscar produto pelo ID
    public function buscarProdutoPorId($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM produto WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $produto = $stmt->fetch();

            if ($produto) {
                return $produto;
            } else {
                return "Produto não encontrado.";
            }
        } catch (PDOException $e) {
            return "Erro ao buscar produto: " . $e->getMessage();
        }
    }

    // Cadastrar produto
    public function cadastrarProduto($nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca)
    {
        try {
            $stmt = $this->pdo->prepare("
            INSERT INTO produto (nome, unidade, preco, observacao, situacao, estoque, preco_custo, est_max, est_min, marca) 
            VALUES (:nome, :unidade, :preco, :observacao, :situacao, :estoque, :preco_custo, :est_max, :est_min, :marca)
        ");

            $stmt->execute([
                ':nome' => $nome,
                ':unidade' => $unidade,
                ':preco' => $preco,
                ':observacao' => $observacao,
                ':situacao' => $situacao,
                ':estoque' => $estoque,
                ':preco_custo' => $preco_custo,
                ':est_max' => $est_max,
                ':est_min' => $est_min,
                ':marca' => $marca
            ]);

            // Redireciona para index com status de sucesso
            header("Location: index.php?status=sucesso&mensagem=Produto cadastrado com sucesso!");
            exit;

        } catch (PDOException $e) {
            header("Location: index.php?status=erro&mensagem=Erro ao cadastrar produto: " . urlencode($e->getMessage()));
            exit;
        }
    }

    // Editar produto
    public function editarProduto($id, $nome, $unidade, $preco, $observacao, $situacao, $estoque, $preco_custo, $est_max, $est_min, $marca)
    {
        try {
            $stmt = $this->pdo->prepare("
            UPDATE produto 
            SET nome = :nome, 
                unidade = :unidade, 
                preco = :preco, 
                observacao = :observacao, 
                situacao = :situacao, 
                estoque = :estoque, 
                preco_custo = :preco_custo, 
                est_max = :est_max, 
                est_min = :est_min, 
                marca = :marca 
            WHERE id = :id
        ");

            $stmt->execute([
                ':id' => $id,
                ':nome' => $nome,
                ':unidade' => $unidade,
                ':preco' => $preco,
                ':observacao' => $observacao,
                ':situacao' => $situacao,
                ':estoque' => $estoque,
                ':preco_custo' => $preco_custo,
                ':est_max' => $est_max,
                ':est_min' => $est_min,
                ':marca' => $marca
            ]);

            // Redireciona para index com status de sucesso
            header("Location: index.php?status=sucesso&mensagem=Produto atualizado com sucesso!");
            exit;

        } catch (PDOException $e) {
            header("Location: index.php?status=erro&mensagem=Erro ao editar produto: " . urlencode($e->getMessage()));
            exit;
        }
    }


    // Deletar produto
    public function deletarProduto($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM produto WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return "Produto deletado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao deletar produto: " . $e->getMessage();
        }
    }

    // Aumentar estoque
    public function aumentarEstoque($id, $quantidade)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE produto SET estoque = estoque + :quantidade WHERE id = :id");
            $stmt->execute([
                ':quantidade' => $quantidade,
                ':id' => $id
            ]);
            return "Estoque aumentado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao aumentar estoque: " . $e->getMessage();
        }
    }

    // Diminuir estoque
    public function diminuirEstoque($id, $quantidade)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE produto SET estoque = estoque - :quantidade WHERE id = :id");
            $stmt->execute([
                ':quantidade' => $quantidade,
                ':id' => $id
            ]);
            return "Estoque reduzido com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao reduzir estoque: " . $e->getMessage();
        }
    }

    // Fazer balanço do estoque
    public function fazerBalanco($id, $estoque)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE produto SET estoque = :estoque WHERE id = :id");
            $stmt->execute([
                ':estoque' => $estoque,
                ':id' => $id
            ]);
            return "Balanço realizado com sucesso! Estoque atualizado para {$estoque}.";
        } catch (PDOException $e) {
            return "Erro ao fazer balanço do estoque: " . $e->getMessage();
        }
    }

}

?>