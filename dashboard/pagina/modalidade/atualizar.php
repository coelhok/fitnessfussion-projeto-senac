<?php

require_once('class/ClassModalidade.php');
require_once('class/Conexao.php');

$id = $_GET['id'];
$modalidade = new ClassModalidade($id);

// Função para contar modalidade com status = SITE
function contarmodalidadeite($conexao)
{
    $sql = "SELECT COUNT(*) AS total FROM modalidade WHERE statusModalidade = 'SITE'";
    $resultado = $conexao->query($sql);
    $contagem = $resultado->fetch(PDO::FETCH_ASSOC);
    return $contagem['total'];
}
// Recuperar a conexão com o banco de dados
$conexao = Conexao::LigarConexao();
if (isset($_POST['nomeModalidade'])) {
    $nomeModalidade = $_POST['nomeModalidade'];
    $conteudoModalidade = $_POST['conteudoModalidade'];
    $statusModalidade = $_POST['statusModalidade'];;
    $altModalidade = "foto" . $nomeModalidade;

    // Verificar se o status da modalidade é SITE e se já existem 3 modalidade com este status
    if ($statusModalidade == 'SITE') {
        $totalmodalidadeite = contarmodalidadeite($conexao);
        if ($totalmodalidadeite >= 3) {
            echo "Não é permitido cadastrar mais de 3 modalidade com o status 'SITE'.";
            exit; // Sair se não for permitido cadastrar mais modalidade com status 'SITE'
        }
    }

    // Verificar se a foto foi modificada
    if (!empty($_FILES['fotoModalidade']['name'])) {
        // Tratar o campo FILES
        $arquivo = $_FILES['fotoModalidade'];
        if ($arquivo['error']) {
            throw new Exception('O erro foi: ' . $arquivo['error']);
        }

        // Obter a extensão do arquivo
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

        $nomeModFoto = str_replace(' ', '', $nomeModalidade); // Remove os espaços em branco do nome
        $nomeModFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeModFoto); // Eliminação de caracteres especiais
        $nomeModFoto = strtolower($nomeModFoto); // Deixar tudo minúsculo

        // O novo nome da imagem
        $novoNome = $modalidade->idModalidade . '_' . $nomeModFoto . '.jpeg';

        // Mover a imagem
        if (move_uploaded_file($arquivo['tmp_name'], 'img/modalidade/' . $novoNome)) {
            $fotoModalidade = $novoNome;
        } else {
            throw new Exception('Não é possível realizar o upload.');
        }
    } else {
        $fotoModalidade = $modalidade->fotoModalidade;
    }

    // Atualizar no banco de dados
    $modalidade->nomeModalidade = $nomeModalidade;
    $modalidade->fotoModalidade = $fotoModalidade;
    $modalidade->statusModalidade = $statusModalidade;
    $modalidade->conteudoModalidade = $conteudoModalidade;

    $modalidade->Atualizar();
}

?>

<div class="container mt-5">
    <h2>Cadastro de Modalidade</h2>
    <form action="index.php?p=modalidade&m=atualizar&id=<?php echo $modalidade->idModalidade; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">

            <div class="col-9">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nomeModalidade" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeModalidade" name="nomeModalidade" placeholder="Nome Modalidade" required value="<?php echo $modalidade->nomeModalidade; ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="statusModalidade" class="form-label">Status</label>
                            <select class="form-select" id="statusModalidade" name="statusModalidade" required>
                                <option value="ATIVO" <?php echo ($modalidade->statusModalidade == 'ATIVO') ? 'selected' : ''; ?>>ATIVO</option>
                                <option value="SITE" <?php echo ($modalidade->statusModalidade == 'SITE') ? 'selected' : ''; ?>>SITE</option>
                                <option value="INATIVO" <?php echo ($modalidade->statusModalidade == 'INATIVO') ? 'selected' : ''; ?>>INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="conteudoModalidade" class="form-label">Conteúdo</label>
                            <textarea class="form-control" id="conteudoModalidade" name="conteudoModalidade" placeholder="Conteúdo Modalidade" rows="4" maxlength="150" required><?php echo $modalidade->conteudoModalidade; ?></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="index.php?p=modalidade" class="btn btn-secondary">Voltar</a>
            </div>
            <div class="col-3">
                <img src="img/modalidade/<?php echo $modalidade->fotoModalidade; ?>" class="img-fluid" alt="foto da modalidade" id="imgFoto">
                <input type="file" class="form-control" id="fotoModalidade" name="fotoModalidade" style="display: none;">
            </div>
        </div>
    </form>
</div>

<script>
    // transformar img em um botão
    document.getElementById('imgFoto').addEventListener('click', function() {
        document.getElementById('fotoModalidade').click();
    });

    document.getElementById('fotoModalidade').addEventListener('change', function(event) {
        let imgFoto = document.getElementById('imgFoto');
        let arquivo = event.target.files[0];

        if (arquivo) {
            let carregar = new FileReader();
            carregar.onload = function(e) {
                imgFoto.src = e.target.result;
            }
            carregar.readAsDataURL(arquivo);
        }
    });
</script>