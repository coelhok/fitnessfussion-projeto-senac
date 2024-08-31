<?php

require_once('Conexao.php');


class ClassModalidade{

    // ATRIBUTOS/ funções/metodos/caracteristicas/valores da classe public para ver te todas as formas e private mas ao contrario
    public $idModalidade;
    public $nomeModalidade;
    public $fotoModalidade;
    public $altModalidade;
    public $statusModalidade;
    public $conteudoModalidade;

    //METODOS DA CLASS

    public function __construct($id = false)
    {
        if ($id) {
            $this->idModalidade = $id;
            $this->Carregar();
        }
    }



    // LISTAR/ maiusculo metodo da classe - minúsculo atributo
    public function Listar(){
        $sql = "select * from modalidade  order by nomeModalidade";
        
        $conn = Conexao::LigarConexao(); // ligando a conexao do arquivo Conexao.php
        
        $resultado = $conn->query($sql); // prepara e executa uma instrução sql sem espaços reservados

        $lista = $resultado->fetchAll(); // busca as linhas restantes de um conjunto de resultados, retonar uma matriz de dados

        return $lista; // retorna a minha matriz de dados, retorna o valor que tem na lista

    }

    // INSERIR 
    public function Inserir()
    {
        $sql = "INSERT INTO modalidade(nomeModalidade, fotoModalidade, statusModalidade, altModalidade, conteudoModalidade)
        
         VALUES ('$this->nomeModalidade',
                '$this->fotoModalidade',
                '$this->statusModalidade',
                '$this->altModalidade',
                '$this->conteudoModalidade')";

        $conn = Conexao::LigarConexao();
        $conn->exec($sql);
    }
    // ATUALIZAR
    public function Atualizar()
    {
        $sql = "UPDATE modalidade SET nomeModalidade = '" . $this->nomeModalidade . "',
                                        fotoModalidade = '" . $this->fotoModalidade . "',
                                        statusModalidade = '" . $this->statusModalidade . "',
                                        conteudoModalidade = '" . $this->conteudoModalidade . "'
                WHERE idModalidade = $this->idModalidade";

        $conn = Conexao::LigarConexao();
        $conn->exec($sql);

        echo "<script>document.location='index.php?p=modalidade'</script>"; // Redireciona para a página de clientes após a atualização
    }
    // CARREGAR, ele serve para carregar os cliente na parte de atualizar o cliente
    public function carregar()
    {
        $sql = "SELECT * FROM modalidade WHERE idModalidade = $this->idModalidade";
        $conn = Conexao::LigarConexao();
        $resultado = $conn->query($sql);
        $modalidade = $resultado->fetch();

        $this->idModalidade = $modalidade['idModalidade'];
        $this->nomeModalidade = $modalidade['nomeModalidade'];
        $this->fotoModalidade = $modalidade['fotoModalidade'];
        $this->statusModalidade = $modalidade['statusModalidade'];
        $this->conteudoModalidade = $modalidade['conteudoModalidade'];
        
    }
}