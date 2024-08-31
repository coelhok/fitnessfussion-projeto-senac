<?php
require_once('class/ClassBanner.php');

// iniciar processo cadastro do cliente ligado ao banco de dados
if (isset($_POST['nomeBanner'])) {
    $nomeBanner = $_POST['nomeBanner'];
    $tipoBanner = $_POST['tipoBanner'];
    $statusBanner = 'ATIVO';  // Você pode definir como 'ATIVO' ou usar $_POST['statusBanner'] conforme sua necessidade
    $altBanner = "foto de " . $nomeBanner;

    // Recuperar o ID
    require_once('class/Conexao.php');
    $conexao = Conexao::LigarConexao();
    $sql = $conexao->query('SELECT idBanner FROM banner ORDER BY idBanner DESC LIMIT 1');
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    $novoId = ($resultado !== false && isset($resultado['idBanner'])) ? $resultado['idBanner'] + 1 : 1;

    // Tratar o campo FILES (foto)
    if (isset($_FILES['foto'])) {
        $arquivo = $_FILES['foto'];

        if ($arquivo['error'] == UPLOAD_ERR_OK) {
            $nomeBanFoto = str_replace(' ', '', $nomeBanner);
            $nomeBanFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeBanFoto);
            $nomeBanFoto = strtolower($nomeBanFoto);

            // O novo nome da imagem
            $novoNome = $novoId . '_' . $nomeBanFoto . '.jpeg';

            // Mover a IMG - para a pasta banner que foi criada dentro de (dashboard/img/banner)
            if (move_uploaded_file($arquivo['tmp_name'], 'img/banner/' . $novoNome)) {
                $fotoBanner = $novoNome;
            } else {
                throw new Exception('Erro ao mover o arquivo.');
            }

            // Inserir os dados no banco de dados
            $banner = new ClassBanner();
            $banner->nomeBanner = $nomeBanner;
            $banner->fotoBanner = $fotoBanner;
            $banner->tipoBanner = $tipoBanner;
            $banner->statusBanner = $statusBanner;
            $banner->altBanner = $altBanner;

            try {
                $banner->Inserir();
                echo "<script>document.location='index.php?p=dashboard'</script>";
            } catch (Exception $e) {
                echo "Erro ao cadastrar banner: " . $e->getMessage();
                exit; // Sair se ocorrer um erro ao cadastrar o banner
            }
        } else {
            throw new Exception('O erro foi: ' . $arquivo['error']);
        }
    } else {
        throw new Exception('Arquivo não enviado.');
    }
}
?>
<div class="container mt-5">
    <h2>Cadastro de Banner</h2>
    <form action="index.php?p=banner&b=inserir" method="POST" enctype="multipart/form-data">
        <div class="row brow">
            <div class="col-3">
                <div class="row brow">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nomeBanner" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeBanner" name="nomeBanner" placeholder="Nome Banner" required>
                        </div>
                    </div>
                </div>
                <div class="row brow">
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="tipoBanner" class="form-label">Tipo</label>
                            <select class="form-select" id="tipoBanner" name="tipoBanner" placeholder="Tipo Banner" required>
                                <option value="PRINCIPAL">PRINCIPAL</option>
                                <option value="SECUNDARIO">SECUNDARIO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="statusBanner" class="form-label">Status</label>
                            <select class="form-select" id="statusBanner" name="statusBanner" placeholder="Status Banner" required>
                                <option value="ATIVO">ATIVO</option>
                                <option value="INATIVO">INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="index.php?p=banner" class="btn btn-secondary">Voltar</a>
            </div>
            <div class="col-9">
                <img src="img/banner/semfoto.jpeg" class="img-fluid bimg-fluid" alt="foto da banner" id="img">
                <input type="file" class="form-control" id="foto" name="foto" style="display: none;" required>
            </div>
        </div>
    </form>
</div>