<?php
// v2

// Inclui o arquivo de configuração
require_once 'config/config_db.php';

class DBConnection {
    private $pdo;

    public function __construct($config) {
        echo "Iniciando a conexão com o banco de dados...\n";
        
        $dsn = "mysql:host={$config->dbhost};dbname={$config->dbdefault};charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $config->dbuser, $config->dbpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexão estabelecida com sucesso.\n";
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage() . "\n";
            die();
        }
    }

    public function listTables() {
        echo "Consultando as tabelas...\n";
        $query = "SHOW TABLES";
        try {
            $stmt = $this->pdo->query($query);
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Consulta concluída com sucesso.\n";
            return $tables;
        } catch (PDOException $e) {
            echo "Erro ao consultar as tabelas: " . $e->getMessage() . "\n";
            return [];
        }
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
