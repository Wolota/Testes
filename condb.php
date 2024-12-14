<?php

// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclua os arquivos principais do GLPI
include('./inc/includes.php');

// Dados do usuário e senha para validação
$username = $_POST['username'] ?? 'admin'; // Substitua por entrada do usuário
$password = $_POST['password'] ?? 'password'; // Substitua por entrada do usuário

// Inicializa a sessão no modo normal
$_SESSION['glpi_use_mode'] = Session::NORMAL_MODE;

// Tenta autenticar o usuário
if (User::checkLogin($username, $password)) {
    // Obtém as informações do usuário
    $user = new User();
    if ($user->getFromDBbyName($username)) {
        echo "Autenticação bem-sucedida! Bem-vindo, " . $user->fields['name'];
    } else {
        echo "Usuário autenticado, mas não encontrado no banco de dados.";
    }
} else {
    echo "Falha na autenticação. Verifique o nome de usuário e a senha.";
}
