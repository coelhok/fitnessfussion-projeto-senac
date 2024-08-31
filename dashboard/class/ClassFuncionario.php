<?php

require_once('Conexao.php');

class ClassFuncionario
{
    public $idFuncionario;
    public $nomeFuncionario;
    public $cargoFuncionario;
    public $fotoFuncionario;
    public $altFuncionario;
    public $telefoneFuncionario;
    public $enderecoFuncionario;
    public $emailFuncionario;
    public $senhaFuncionario;
    public $statusFuncionario;
    public $dataCadFuncionario;
    public $salarioFuncionario;
    public $descricaoFuncionario;

    public function Listar()
    {
        $sql = "SELECT * FROM funcionario ORDER BY nomeFuncionario ASC";

        $conn = Conexao::LigarConexao(); // ligando a conexao do arquivo Conexao.php

        $resultado = $conn->query($sql); // prepara e executa uma instrução sql sem espaços reservados

        $lista = $resultado->fetchAll(); // busca as linhas restantes de um conjunto de resultados, retorna uma matriz de dados

        return $lista; // retorna a matriz de dados
    }

    public function Verificarlogin()
    {
        $sql = "SELECT * FROM funcionario WHERE emailFuncionario = :emailFuncionario AND senhaFuncionario = :senhaFuncionario AND statusFuncionario = 'ATIVO'";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':emailFuncionario', $this->emailFuncionario);
        $stmt->bindParam(':senhaFuncionario', $this->senhaFuncionario);
        $stmt->execute();
        $funcionario = $stmt->fetch();

        if ($funcionario) {
            return $funcionario['idFuncionario'];
        } else {
            return false;
        }
    }

    public function BuscarPorId($id)
    {
        $sql = "SELECT * FROM funcionario WHERE idFuncionario = :idFuncionario";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idFuncionario', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

if (isset($_POST['email'])) {
    $funcionario = new ClassFuncionario();
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $funcionario->emailFuncionario = $email;
    $funcionario->senhaFuncionario = $senha;

    if ($idFuncionario = $funcionario->Verificarlogin()) {
        session_start();
        $_SESSION['idFuncionario'] = $idFuncionario;
        echo json_encode(['success' => true, 'message' => 'login OK']);
    } else {
        echo json_encode(['success' => false, 'message' => 'login invalido']);
    }
}
