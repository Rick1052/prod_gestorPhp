<?php
require_once __DIR__ . '/../database/db_connect.php'; // Corrige o caminho

class User {
    private $pdo;

    // Construtor que cria a instância da classe Database para obter a conexão
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection(); // Agora o método getConnection() está disponível
    }

    public function register($username, $email, $password) {
        // Verificar se o e-mail já existe
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return "Email já registrado!";
        }

        // Inserir o novo usuário no banco de dados
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Criptografando a senha
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        
        try {
            $stmt->execute([$username, $email, $passwordHash]);
            return "Cadastro realizado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao cadastrar: " . $e->getMessage();
        }
    }

    public function login($email, $password) {
        // Verificar se o usuário existe
        $stmt = $this->pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // O login foi bem-sucedido, armazenar as informações na sessão
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            return true; // Login bem-sucedido
        }

        return false; // Credenciais inválidas
    }

    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function getUserInfo() {
        session_start();
        if ($this->isLoggedIn()) {
            return [
                'user_id' => $_SESSION['user_id'],
                'username' => $_SESSION['username']
            ];
        }
        return null;
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
?>
