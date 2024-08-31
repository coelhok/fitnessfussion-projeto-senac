<?php



        // Dados de conexão com o banco de dados
        $host           = 'smpsistema.com.br'; // Host do banco de dados
        $dbname         = 'u283879542_fitnessfusion'; // Nome do banco de dados
        $username       = 'u283879542_fitnessfusion'; // Nome de usuário do banco de dados
        $password       = 'Senac@fitnessfusion01'; // Senha do banco de dados

try {
    //conexao com a porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $username, $password);

    //conexao com a porta
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $username, $password);

    //echo "conexao com o banco de dados realizado com sucesso.";
  
} catch (PDOException $err) {
    die( "Erro: Conexao com o banco falhou" . $err->getMessage());
}