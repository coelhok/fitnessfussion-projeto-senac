<?php
require_once('../dashboard/class/Conexao.php');
require_once('../dashboard/class/ClassCliente.php');

header('Content-Type: application/json');

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    
    $cliente = new ClassCliente();
    $result = $cliente->Pesquisar($query);
    
    echo json_encode($result);
}
?>