<?php

require_once('Conexao.php');


class ClassBanner
{

    // ATRIBUTOS/ funções/metodos/caracteristicas/valores da classe public para ver te todas as formas e private mas ao contrario
    public $idBanner;
    public $nomeBanner;
    public $fotoBanner;
    public $altBanner;
    public $statusBanner;
    public $tipoBanner;

    //METODOS DA CLASS

    public function __construct($id = false)
    {
        if ($id) {
            $this->idBanner = $id;
            $this->Carregar();
        }
    }



    // LISTAR/ maiusculo metodo da classe - minúsculo atributo
    public function Listar()
    {
        $sql = "select*from banner  order by nomeBanner ASC";

        $conn = Conexao::LigarConexao(); // ligando a conexao do arquivo Conexao.php

        $resultado = $conn->query($sql); // prepara e executa uma instrução sql sem espaços reservados

        $lista = $resultado->fetchAll(); // busca as linhas restantes de um conjunto de resultados, retonar uma matriz de dados

        return $lista; // retorna a minha matriz de dados, retorna o valor que tem na lista

    }

    // INSERIR 
    public function Inserir()
    {
        $sql = "INSERT INTO banner (nomeBanner, fotoBanner, statusBanner, altBanner, tipoBanner)
        
         VALUES ('$this->nomeBanner',
                '$this->fotoBanner',
                '$this->statusBanner',
                '$this->altBanner',
                '$this->tipoBanner')";

        $conn = Conexao::LigarConexao();
        $conn->exec($sql);

        //echo "<script>document.location='index.php?p=banner'</script>"; // Redireciona para a página de clientes após a atualização
    }

    // ATUALIZAR
    public function Atualizar()
    {
        $sql = "UPDATE banner SET 
            nomeBanner = :nomeBanner,
            fotoBanner = :fotoBanner,
            statusBanner = :statusBanner,
            tipoBanner = :tipoBanner
            WHERE idBanner = :idBanner";

        $conn = Conexao::LigarConexao();
        $stmt = $conn->prepare($sql);

        // Vincular parâmetros
        $stmt->bindParam(':nomeBanner', $this->nomeBanner);
        $stmt->bindParam(':fotoBanner', $this->fotoBanner);
        $stmt->bindParam(':statusBanner', $this->statusBanner);
        $stmt->bindParam(':tipoBanner', $this->tipoBanner);
        $stmt->bindParam(':idBanner', $this->idBanner, PDO::PARAM_INT);

        $stmt->execute();

        echo "<script>document.location='index.php?p=banner'</script>"; // Redireciona para a página de banners após a atualização
    }




    // CARREGAR, ele serve para carregar os cliente na parte de atualizar o cliente
    public function carregar()
    {
        $sql = "SELECT * FROM banner WHERE idBanner = $this->idBanner";
        $conn = Conexao::LigarConexao();
        $resultado = $conn->query($sql);
        $banner = $resultado->fetch();

        $this->idBanner = $banner['idBanner'];
        $this->nomeBanner = $banner['nomeBanner'];
        $this->fotoBanner = $banner['fotoBanner'];
        $this->statusBanner = $banner['statusBanner'];
        $this->tipoBanner = $banner['tipoBanner'];
    }

    // DESATIVAR
    public function Desativar($id)
    { //quando esse metodo for chamado tem que passar um parametro

        $sql = "UPDATE banner SET statusBanner = 'INATIVO' WHERE idBanner = $id";
        $conn = Conexao::LigarConexao(); // abrir execusao
        $conn->exec($sql); // executar

        echo "<script>document.location='index.php?p=banner'</script>";
    }
}
