<?php

require_once('Conexao.php');

/*$conn = Conexao::LigarConexao();

if ($conn) {
    echo "Conexão OK";
}else{
    echo "Falhar na Conexão OK";
}*/


class ClassContato{

    // ATRIBUTOS/ funções/metodos/caracteristicas/valores da classe
    public $idContato;
    public $nomeContato;
    public $emailContato;
    public $telefoneContato;
    public $mensagemContato;
    public $statusContato;
    public $dataContato;
    public $horaContato;

    public function __construct($id = false)
    {
        if ($id) {
            $this->idContato = $id;
            $this->Carregar();
        }
    }


    // LISTAR/ maiusculo metodo da classe - minúsculo atributo
    public function Listar(){
        $sql = "select * from contato Order by dataContato Desc";
        
        $conn = Conexao::LigarConexao(); // ligando a conexao do arquivo Conexao.php
        
        $resultado = $conn->query($sql); // prepara e executa uma instrução sql sem espaços reservados

        $lista = $resultado->fetchAll(); // busca as linhas restantes de um conjunto de resultados, retonar uma matriz de dados

        return $lista; // retorna a minha matriz de dados

    }

    // CARREGAR, ele serve para carregar os cliente na parte de atualizar o cliente
    public function carregar()
    {
        $sql = "SELECT * FROM contato WHERE idContato = $this->idContato";
        $conn = Conexao::LigarConexao();
        $resultado = $conn->query($sql);
        $contato = $resultado->fetch();

        $this->idContato = $contato['idContato'];
        $this->nomeContato = $contato['nomeContato'];
        $this->emailContato = $contato['emailContato'];
        $this->telefoneContato = $contato['telefoneContato'];
        $this->mensagemContato = $contato['mensagemContato'];
        $this->statusContato = $contato['statusContato'];
        $this->dataContato = $contato['dataContato'];
        $this->horaContato = $contato['horaContato'];
        
    }

    // ATUALIZAR
    public function Atualizar()
    {
        $sql = "UPDATE contato SET statusContato = 'LIDO' where idContato = $this->idContato";

        $conn = Conexao::LigarConexao();
        $conn->exec($sql);

        echo "<script>document.location='index.php?p=contato'</script>"; // Redireciona para a página de clientes após a atualização
    }



    
}