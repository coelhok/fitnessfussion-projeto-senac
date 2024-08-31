<?php

require_once('Conexao.php');


class ClassPostagem
{

    // ATRIBUTOS/ funções/metodos/caracteristicas/valores da classe public para ver te todas as formas e private mas ao contrario
    public $idPostagem;
    public $idFuncionario;
    public $nomeFuncionario;
    public $tituloPostagem;
    public $conteudoPostagem;
    public $fotoPostagem;
    public $altPostagem;
    public $dataPostagem;
    public $statusPostagem;
    public $categoriaPostagem;
    public $visualizacoesPostagem;

    //METODOS DA CLASS

    public function __construct($id = false)
    {
        if ($id) {
            $this->idPostagem = $id;
            $this->carregar();
        }
    }


    public function Listar(){
        $sql = "SELECT 
                    p.idPostagem,  
                    p.fotoPostagem,
                    p.tituloPostagem,
                    p.altPostagem, 
                    p.conteudoPostagem, 
                    f.nomeFuncionario, 
                    p.statusPostagem, 
                    p.visualizacoesPostagem,
                    p.categoriaPostagem,
                    p.dataPostagem 
                FROM 
                    postagem p
                JOIN 
                    funcionario f ON p.idFuncionario = f.idFuncionario";
    
        $conn = Conexao::LigarConexao();
        $resultado = $conn->query($sql);
        $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }
    

    public function Inserir()
    {
        $sql = "INSERT INTO postagem (tituloPostagem, fotoPostagem, statusPostagem, altPostagem, conteudoPostagem, idFuncionario, categoriaPostagem)
                VALUES (:tituloPostagem, :fotoPostagem, :statusPostagem, :altPostagem, :conteudoPostagem, :idFuncionario, :categoriaPostagem)";

        try {
            $conn = Conexao::LigarConexao();
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':tituloPostagem', $this->tituloPostagem);
            $stmt->bindParam(':fotoPostagem', $this->fotoPostagem);
            $stmt->bindParam(':statusPostagem', $this->statusPostagem);
            $stmt->bindParam(':altPostagem', $this->altPostagem);
            $stmt->bindParam(':conteudoPostagem', $this->conteudoPostagem);
            $stmt->bindParam(':idFuncionario', $this->idFuncionario);
            $stmt->bindParam(':categoriaPostagem', $this->categoriaPostagem);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao inserir postagem: " . $e->getMessage();
        }
    }

    // ATUALIZAR
    public function Atualizar()
    {
        $sql = "UPDATE postagem SET tituloPostagem = :tituloPostagem,
                                fotoPostagem = :fotoPostagem,
                                statusPostagem = :statusPostagem,
                                conteudoPostagem = :conteudoPostagem,
                                categoriaPostagem = :categoriaPostagem
            WHERE idPostagem = :idPostagem";

        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tituloPostagem', $this->tituloPostagem);
        $stmt->bindParam(':fotoPostagem', $this->fotoPostagem);
        $stmt->bindParam(':statusPostagem', $this->statusPostagem);
        $stmt->bindParam(':conteudoPostagem', $this->conteudoPostagem);
        $stmt->bindParam(':categoriaPostagem', $this->categoriaPostagem);
        $stmt->bindParam(':idPostagem', $this->idPostagem, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>document.location='index.php?p=postagem'</script>"; // Redireciona para a página de clientes após a atualização
    }





    // CARREGAR, ele serve para carregar os clientes na parte de atualizar o cliente
    public function carregar()
    {
        $sql = "SELECT * FROM postagem WHERE idPostagem = :idPostagem";
        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idPostagem', $this->idPostagem, PDO::PARAM_INT);
        $stmt->execute();
        $postagem = $stmt->fetch();

        if ($postagem) {
            $this->idPostagem = $postagem['idPostagem'];
            $this->tituloPostagem = $postagem['tituloPostagem'];
            $this->altPostagem = $postagem['altPostagem'];
            $this->fotoPostagem = $postagem['fotoPostagem'];
            $this->statusPostagem = $postagem['statusPostagem'];
            $this->conteudoPostagem = $postagem['conteudoPostagem'];
            $this->categoriaPostagem = $postagem['categoriaPostagem'];
        } else {
            // Caso não encontre a postagem, pode definir valores padrão ou lançar uma exceção
            echo "Postagem não encontrada.";
        }
    }


    // DESATIVAR
    public function Desativar($id)
    { //quando esse metodo for chamado tem que passar um parametro

        $sql = "UPDATE modalidade SET statusModalidade = 'INATIVO' WHERE idModalidade = $id";
        $conn = Conexao::LigarConexao(); // abrir execusao
        $conn->exec($sql); // executar

        echo "<script>document.location='index.php?p=modalidade'</script>";
    }
}
