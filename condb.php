<?php

// Inclui o arquivo de configuração
$config = include 'config_db.php';

class DBConnection {
    private $mysqli;

    public function __construct($config) {
        echo "<h3>Iniciando a conexão com o banco de dados...</h3>";

        $this->mysqli = new mysqli($config['dbhost'], $config['dbuser'], $config['dbpassword'], $config['dbdefault']);

        if ($this->mysqli->connect_error) {
            echo "<h3>Erro na conexão: " . $this->mysqli->connect_error . "</h3>";
            die();
        } else {
            echo "<h3>Conexão estabelecida com sucesso.</h3>";
        }
    }

    public function listTables() {
        echo "<h3>Consultando as tabelas...</h3>";
        $query = "SHOW TABLES";
        $result = $this->mysqli->query($query);

        if ($result) {
            echo "<h3>Consulta concluída com sucesso.</h3>";
            $tables = [];
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            $result->free();
            return $tables;
        } else {
            echo "<h3>Erro ao consultar as tabelas: " . $this->mysqli->error . "</h3>";
            return [];
        }
    }

    public function close() {
        $this->mysqli->close();
        echo "<h3>Conexão fechada.</h3>";
    }
}

// Instancia a conexão usando as configurações
$dbConnection = new DBConnection($config);
$tables = $dbConnection->listTables();

// Exibe as tabelas
echo "<h3>Tabelas no banco de dados {$config['dbdefault']}:</h3>";
foreach ($tables as $table) {
    echo "<h3>{$table}</h3>";
}

// Fecha a conexão
$dbConnection->close();
?>
