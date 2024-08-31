<?php

require_once('Conexao.php');

class ClassFeedback
{
    public $nomeCliente;
    public $idFeedback;
    public $idCliente;
    public $dataFeedback;
    public $tipoFeedback;
    public $conteudoFeedback;

    public function __construct($id = false)
    {
        if ($id) {
            $this->idFeedback = $id; // Corrigido para usar o "F" maiúsculo
            $this->Carregar();
        }
    }

    public function Listar()
    {
        $sql = "SELECT 
                    cliente.nomeCliente, 
                    feedback.idFeedback,
                    feedback.dataFeedback,
                    feedback.tipoFeedback,
                    feedback.conteudoFeedback 
                FROM 
                    feedback
                INNER JOIN 
                    cliente
                ON 
                    feedback.idCliente = cliente.idCliente";

        $conn = Conexao::LigarConexao(); // ligando a conexao do arquivo Conexao.php

        $resultado = $conn->query($sql); // prepara e executa uma instrução sql sem espaços reservados

        $lista = $resultado->fetchAll(); // busca as linhas restantes de um conjunto de resultados, retorna uma matriz de dados

        return $lista; // retorna a matriz de dados
    }

    // CARREGAR, ele serve para carregar os clientes na parte de atualizar o cliente
    public function Carregar()
    {
        $sql = "SELECT 
                    cliente.nomeCliente, 
                    feedback.idFeedback,
                    feedback.idCliente,
                    feedback.dataFeedback,
                    feedback.tipoFeedback,
                    feedback.conteudoFeedback 
                FROM 
                    feedback
                INNER JOIN 
                    cliente
                ON 
                    feedback.idCliente = cliente.idCliente
                WHERE 
                    feedback.idFeedback = :idFeedback";

        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idFeedback', $this->idFeedback, PDO::PARAM_INT); // Bind the parameter
        $stmt->execute();
        
        $feedback = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array

        if ($feedback) {
            $this->idCliente = $feedback['idCliente'];
            $this->nomeCliente = $feedback['nomeCliente'];
            $this->dataFeedback = $feedback['dataFeedback'];
            $this->tipoFeedback = $feedback['tipoFeedback'];
            $this->conteudoFeedback = $feedback['conteudoFeedback'];
        } else {
            throw new Exception("Feedback não encontrado.");
        }
    }
}
