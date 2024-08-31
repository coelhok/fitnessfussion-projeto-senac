<?php
require_once('Conexao.php');

class ClassCliente
{
    public $idCliente;
    public $treinoCliente;
    public $planoCliente;
    public $idAvaliacaoFisica;
    public $nomeCliente;
    public $cpfCliente;
    public $telefoneCliente;
    public $dataNascCliente;
    public $emailCliente;
    public $senhaCliente;
    public $statusCliente;
    public $fotoCliente;
    public $altCliente;
    public $dataCadCliente;
    public $metodoPagamento;

    public function __construct($id = null)
    {
        if ($id) {
            $this->idCliente = $id;
            $this->carregar();
        }
    }

    public function carregar()
    {
        $sql = "SELECT c.*, p.metodoPagamento 
            FROM cliente c 
            LEFT JOIN pagamento p ON c.idCliente = p.idCliente 
            WHERE c.idCliente = :idCliente";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $this->idCliente = $cliente['idCliente'];
            $this->treinoCliente = $cliente['idTreino'];
            $this->planoCliente = $cliente['idPlano'];
            $this->nomeCliente = $cliente['nomeCliente'];
            $this->cpfCliente = $cliente['cpfCliente'];
            $this->telefoneCliente = $cliente['telefoneCliente'];
            $this->dataNascCliente = $cliente['dataNascCliente'];
            $this->emailCliente = $cliente['emailCliente'];
            $this->senhaCliente = $cliente['senhaCliente'];
            $this->statusCliente = $cliente['statusCliente'];
            $this->fotoCliente = $cliente['fotoCliente'];
            $this->altCliente = $cliente['altCliente'];
            $this->dataCadCliente = $cliente['dataCadCliente'];
            $this->metodoPagamento = $cliente['metodoPagamento']; // Incluindo o método de pagamento
        }
    }

    // Função para verificar duplicidade de CPF
    public function cpfDuplicado()
    {
        $sql = "SELECT COUNT(*) FROM cliente WHERE cpfCliente = :cpfCliente";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpfCliente', $this->cpfCliente);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function emailDuplicado()
    {
        $sql = "SELECT COUNT(*) FROM cliente WHERE emailCliente = :emailCliente";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':emailCliente', $this->emailCliente);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Método para inserir cliente e pagamento associado
    public function Inserir()
    {
        if ($this->cpfDuplicado()) {
            throw new Exception("CPF já cadastrado.");
            echo "<script>document.location='index.php?p=dashboard'</script>";
        }
        if ($this->emailDuplicado()) {
            throw new Exception("E-mail já cadastrado.");
            echo "<script>document.location='index.php?p=dashboard'</script>";
        }

        // Preparar a conexão
        $conn = Conexao::LigarConexao();

        // Inserir cliente
        $sqlCliente = "INSERT INTO cliente (idTreino, idPlano, nomeCliente, cpfCliente, telefoneCliente, statusCliente, dataNascCliente, emailCliente, senhaCliente, fotoCliente, altCliente) 
                   VALUES (:idTreino, :idPlano, :nomeCliente, :cpfCliente, :telefoneCliente, :statusCliente, :dataNascCliente, :emailCliente, :senhaCliente, :fotoCliente, :altCliente)";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bindParam(':idTreino', $this->treinoCliente);
        $stmtCliente->bindParam(':idPlano', $this->planoCliente);
        $stmtCliente->bindParam(':nomeCliente', $this->nomeCliente);
        $stmtCliente->bindParam(':cpfCliente', $this->cpfCliente);
        $stmtCliente->bindParam(':telefoneCliente', $this->telefoneCliente);
        $stmtCliente->bindParam(':statusCliente', $this->statusCliente);
        $stmtCliente->bindParam(':dataNascCliente', $this->dataNascCliente);
        $stmtCliente->bindParam(':emailCliente', $this->emailCliente);
        $stmtCliente->bindParam(':senhaCliente', $this->senhaCliente);
        $stmtCliente->bindParam(':fotoCliente', $this->fotoCliente); // Use o nome da foto em minúsculas
        $stmtCliente->bindParam(':altCliente', $this->altCliente);
        $stmtCliente->execute();

        // Obter o ID do cliente inserido
        $this->idCliente = $conn->lastInsertId();

        // Atualizar o campo fotoCliente com idCliente e nomeCliente
        $nomeClienteFormatado = str_replace(' ', '', strtolower($this->nomeCliente)); // Remover espaços e converter para minúsculas
        $nomeClienteFormatado = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeClienteFormatado); // Eliminar caracteres especiais
        $this->fotoCliente = $this->idCliente . '_' . $nomeClienteFormatado . '.' . pathinfo($this->fotoCliente, PATHINFO_EXTENSION);
        $sqlUpdateFoto = "UPDATE cliente SET fotoCliente = :fotoCliente WHERE idCliente = :idCliente";
        $stmtUpdateFoto = $conn->prepare($sqlUpdateFoto);
        $stmtUpdateFoto->bindParam(':fotoCliente', $this->fotoCliente);
        $stmtUpdateFoto->bindParam(':idCliente', $this->idCliente);
        $stmtUpdateFoto->execute();

        // Inserir pagamento associado ao cliente
        $statusPagamento = 'PAGO';
        $sqlPagamento = "INSERT INTO pagamento (idCliente, idPlano, metodoPagamento, statusPagamento) VALUES (:idCliente, :idPlano, :metodoPagamento, :statusPagamento)";
        $stmtPagamento = $conn->prepare($sqlPagamento);
        $stmtPagamento->bindParam(':idCliente', $this->idCliente);
        $stmtPagamento->bindParam(':idPlano', $this->planoCliente);
        $stmtPagamento->bindParam(':metodoPagamento', $this->metodoPagamento);
        $stmtPagamento->bindParam(':statusPagamento', $statusPagamento);
        $stmtPagamento->execute();
    }


    // LISTAR
    public function Listar()
    {
        $sql = "SELECT     
                c.idCliente,
                c.nomeCliente,
                c.emailCliente,
                c.senhaCliente,
                c.fotoCliente,
                c.altCliente,
                c.telefoneCliente,
                c.statusCliente,
                c.dataNascCliente,
                c.dataCadCliente,
                c.cpfCliente,
                p.nomePlano,
                t.nomeTreino
            FROM
                cliente c
            INNER JOIN
                planoAssinatura p ON c.idPlano = p.idPlano
            INNER JOIN
                treino t ON c.idTreino = t.idTreino";

        $conn = Conexao::LigarConexao();

        $resultado = $conn->query($sql);

        $lista = $resultado->fetchAll();

        return $lista;
    }
    public function Pesquisar($nomeCliente)
    {
        // Corrigido para garantir que apenas os nomes que começam com o texto inserido sejam retornados
        $sql = "SELECT idCliente, nomeCliente FROM cliente WHERE nomeCliente LIKE :nomeCliente ORDER BY nomeCliente";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $nomeCliente = $nomeCliente . "%"; // Alterado para buscar nomes que começam com o texto inserido
        $stmt->bindParam(':nomeCliente', $nomeCliente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ATUALIZAR
    public function Atualizar()
    {
        $sql = "UPDATE cliente SET 
                    idTreino = :treinoCliente,
                    idPlano = :planoCliente,
                    nomeCliente = :nomeCliente,
                    cpfCliente = :cpfCliente,
                    telefoneCliente = :telefoneCliente,
                    dataNascCliente = :dataNascCliente,
                    emailCliente = :emailCliente,
                    senhaCliente = :senhaCliente,
                    statusCliente = :statusCliente,
                    fotoCliente = :fotoCliente,
                    altCliente = :altCliente
                WHERE idCliente = :idCliente";

        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);

        // Certifique-se de que os dados estejam prontos para serem enviados para o banco de dados
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':treinoCliente', $this->treinoCliente, PDO::PARAM_INT);
        $stmt->bindParam(':planoCliente', $this->planoCliente, PDO::PARAM_INT);
        $stmt->bindParam(':nomeCliente', $this->nomeCliente, PDO::PARAM_STR);
        $stmt->bindParam(':cpfCliente', $this->cpfCliente, PDO::PARAM_STR);
        $stmt->bindParam(':telefoneCliente', $this->telefoneCliente, PDO::PARAM_STR);
        $stmt->bindParam(':dataNascCliente', $this->dataNascCliente, PDO::PARAM_STR);
        $stmt->bindParam(':emailCliente', $this->emailCliente, PDO::PARAM_STR);
        $stmt->bindParam(':senhaCliente', $this->senhaCliente, PDO::PARAM_STR);
        $stmt->bindParam(':statusCliente', $this->statusCliente, PDO::PARAM_STR);
        $stmt->bindParam(':fotoCliente', $this->fotoCliente, PDO::PARAM_STR);
        $stmt->bindParam(':altCliente', $this->altCliente, PDO::PARAM_STR);

        $stmt->execute();

        // Atualizar pagamento associado ao cliente
        $sqlPagamento = "UPDATE pagamento SET metodoPagamento = :metodoPagamento WHERE idCliente = :idCliente";
        $stmtPagamento = $conn->prepare($sqlPagamento);
        $stmtPagamento->bindParam(':metodoPagamento', $this->metodoPagamento);
        $stmtPagamento->bindParam(':idCliente', $this->idCliente);
        $stmtPagamento->execute();

        echo "<script>document.location='index.php?p=aluno'</script>"; // Redireciona para a página de clientes após a atualização
    }


    public function Verificarlogin()
    {
        $sql = "SELECT * FROM cliente WHERE emailCliente = :emailCliente AND senhaCliente = :senhaCliente AND statusCliente = 'ATIVO'";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':emailCliente', $this->emailCliente);
        $stmt->bindParam(':senhaCliente', $this->senhaCliente);
        $stmt->execute();
        $cliente = $stmt->fetch();

        if ($cliente) {
            return $cliente['idCliente'];
        } else {
            return false;
        }
    }

    public function BuscarPorId($id)
    {
        $sql = "SELECT * FROM cliente WHERE idCliente = :idCliente";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idCliente', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

if (isset($_POST['email'])) {
    $cliente = new ClassCliente();
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $cliente->emailCliente = $email;
    $cliente->senhaCliente = $senha;

    if ($idCliente = $cliente->Verificarlogin()) {
        session_start();
        $_SESSION['idCliente'] = $idCliente;
        echo json_encode(['success' => true, 'message' => 'Login OK']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Login inválido']);
    }
}
