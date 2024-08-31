<?php
require_once('class/Conexao.php');
require_once('class/ClassBanner.php');

$id = $_GET['id'];
$banner = new ClassBanner($id);

if (isset($_POST['nomeBanner'])) {
    $nomeBanner = $_POST['nomeBanner'];
    $tipoBanner = $_POST['tipoBanner'];
    $statusBanner = $_POST['statusBanner'];

    // Verificar se a foto foi modificada
    if (!empty($_FILES['foto']['name'])) {
        // Tratar o campo FILES
        $arquivo = $_FILES['foto'];
        if ($arquivo['error'] != UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload do arquivo: ' . $arquivo['error']);
        }

        $nomeBanFoto = str_replace(' ', '', $nomeBanner); // Remove os espaços em branco do nome
        $nomeBanFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeBanFoto); // Eliminação de caracteres especiais
        $nomeBanFoto = strtolower($nomeBanFoto); // Deixar tudo minúsculo

        // O novo nome da imagem
        $novoNome = $banner->idBanner . '_' . $nomeBanFoto . '.jpeg';

        // Mover a imagem
        if (move_uploaded_file($arquivo['tmp_name'], 'img/banner/' . $novoNome)) {
            $fotoBanner = $novoNome;
        } else {
            throw new Exception('Não foi possível realizar o upload.');
        }
    } else {
        $fotoBanner = $banner->fotoBanner;
    }

    // Atualizar no banco de dados
    $banner->nomeBanner = $nomeBanner;
    $banner->fotoBanner = $fotoBanner;
    $banner->statusBanner = $statusBanner;
    $banner->tipoBanner = $tipoBanner;

    $banner->Atualizar();
}
?>

<div class="container mt-5">
    <h2>Atualizar Banner</h2>
    <form action="index.php?p=banner&b=atualizar&id=<?php echo $banner->idBanner; ?>" method="POST" enctype="multipart/form-data">

        <div class="row brow">
            <div class="col-3">
                <div class="row brow">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nomeBanner" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeBanner" name="nomeBanner" placeholder="Nome Banner" required value="<?php echo $banner->nomeBanner; ?>">
                        </div>
                    </div>
                </div>

                <div class="row brow">
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="tipoBanner" class="form-label">Tipo</label>
                            <select class="form-select" id="tipoBanner" name="tipoBanner" required>
                                <option value="PRINCIPAL" <?php echo ($banner->tipoBanner == 'PRINCIPAL') ? 'selected' : ''; ?>>PRINCIPAL</option>
                                <option value="SECUNDARIO" <?php echo ($banner->tipoBanner == 'SECUNDARIO') ? 'selected' : ''; ?>>SECUNDARIO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3">
                            <label for="statusBanner" class="form-label">Status</label>
                            <select class="form-select" id="statusBanner" name="statusBanner" required>
                                <option value="ATIVO" <?php echo ($banner->statusBanner == 'ATIVO') ? 'selected' : ''; ?>>ATIVO</option>
                                <option value="INATIVO" <?php echo ($banner->statusBanner == 'INATIVO') ? 'selected' : ''; ?>>INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="index.php?p=banner" class="btn btn-secondary">Voltar</a>
            </div>
            <div class="col-9">
                <img src="img/banner/<?php echo $banner->fotoBanner; ?>" class="img-fluid bimg-fluid" alt="foto da banner" id="img">
                <input type="file" class="form-control" id="foto" name="foto" style="display: none;">
            </div>
        </div>
    </form>
</div>
