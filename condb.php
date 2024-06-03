<?php

// Inclui o arquivo de configuração
require_once 'config/config_db.php';

class DBConnection {
    private $pdo;

    public function __construct($config) {
        $dsn = "mysql:host={$config->dbhost};dbname={$config->dbdefault}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        if ($config->use_utf8mb4) {
            $dsn .= ";charset=utf8mb4";
        }

        try {
            $this->pdo = new PDO($dsn, $config->dbuser, $config->dbpassword, $options);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function listTables() {
        $query = "SHOW TABLES";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

// Instancia a classe DB para obter as configurações
$config = new DB();

// Instancia a conexão usando as configurações
$dbConnection = new DBConnection($config);
$tables = $dbConnection->listTables();

// Exibe as tabelas
echo "Tabelas no banco de dados {$config->dbdefault}:\n";
foreach ($tables as $table) {
    echo $table . "\n";
}
?>
