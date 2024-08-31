<?php
require_once('class/Conexao.php');
require_once('class/ClassModalidade.php');

// Função para contar modalidade com status = SITE
function contarmodalidadeite($conexao) {
    $sql = "SELECT COUNT(*) AS total FROM modalidade WHERE statusModalidade = 'SITE'";
    $resultado = $conexao->query($sql);
    $contagem = $resultado->fetch(PDO::FETCH_ASSOC);
    return $contagem['total'];
}

// Iniciar processo de cadastro da modalidade
if (isset($_POST['nomeModalidade'])) {
    $nomeModalidade = $_POST['nomeModalidade'];
    $statusModalidade = $_POST['statusModalidade'];
    $altModalidade = "foto de " . $nomeModalidade;
    $conteudoModalidade = $_POST['conteudoModalidade'];

    // Recuperar a conexão com o banco de dados
    $conexao = Conexao::LigarConexao();

    // Verificar se o status da modalidade é SITE e se já existem 3 modalidade com este status
    if ($statusModalidade == 'SITE') {
        $totalmodalidadeite = contarmodalidadeite($conexao);
        if ($totalmodalidadeite >= 3) {
            echo "Não é permitido cadastrar mais de 3 modalidade com o status 'SITE'.";
            exit; // Sair se não for permitido cadastrar mais modalidade com status 'SITE'
        }
    }

    // Tratar o campo FILES (foto)
    if (isset($_FILES['foto'])) {
        $arquivo = $_FILES['foto'];

        if ($arquivo['error'] == UPLOAD_ERR_OK) {
            $nomeModalidadeFoto = str_replace(' ', '', $nomeModalidade);
            $nomeModalidadeFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomeModalidadeFoto);
            $nomeModalidadeFoto = strtolower($nomeModalidadeFoto);

            // O novo nome da imagem
            $novoNome = uniqid() . '_' . $nomeModalidadeFoto . '.jpeg';

            // Mover a IMG para a pasta modalidade
            if (move_uploaded_file($arquivo['tmp_name'], 'img/modalidade/' . $novoNome)) {
                $fotoModalidade = $novoNome;
            } else {
                throw new Exception('Erro ao mover o arquivo.');
            }

            // Inserir os dados no banco de dados
            $modalidade = new ClassModalidade();
            $modalidade->nomeModalidade = $nomeModalidade;
            $modalidade->fotoModalidade = $fotoModalidade;
            $modalidade->statusModalidade = $statusModalidade;
            $modalidade->altModalidade = $altModalidade;
            $modalidade->conteudoModalidade = $conteudoModalidade;

            try {
                $modalidade->Inserir();
                echo "<script>document.location='index.php?p=modalidade'</script>";
            } catch (Exception $e) {
                echo "Erro ao cadastrar modalidade: " . $e->getMessage();
                exit; // Sair se ocorrer um erro ao cadastrar a modalidade
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
    <h2>Cadastro de Modalidade</h2>
    <form action="index.php?p=modalidade&m=inserir" method="POST" enctype="multipart/form-data">

        <div class="row">

            

            <div class="col-9">

                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nomeModalidade" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeModalidade" name="nomeModalidade" placeholder="Nome Modalidade" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="statusModalidade" class="form-label">Status</label>
                            <select class="form-select" id="statusModalidade" name="statusModalidade" placeholder="Status Modalidade" required>
                                <option value="ATIVO">ATIVO</option>
                                <option value="SITE">SITE</option>
                                <option value="INATIVO">INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="conteudoModalidade" class="form-label">Conteúdo</label>
                            <textarea class="form-control" id="conteudoModalidade" name="conteudoModalidade" placeholder="Conteúdo Modalidade" rows="4" maxlength="150" required></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="index.php?p=modalidade" class="btn btn-secondary">Voltar</a>
            </div>
            <div class="col-3">
                <img src="img/modalidade/semfoto.jpeg" class="img-fluid" alt="foto da modalidade" id="imgFoto">
                <input type="file" class="form-control" id="fotoModalidade" name="fotoModalidade" required style="display: none;">
            </div>
        </div>
    </form>
</div>

<script>
    // transformar img em um botão
    document.getElementById('imgFoto').addEventListener('click', function() {
        // alert ('click na IMG');
        document.getElementById('fotoModalidade').click();
    })

    document.getElementById('fotoModalidade').addEventListener('change', function(event) {

        let imgFoto = document.getElementById('imgFoto'); //variavel
        let arquivo = event.target.files[0]; //variavel - quando insire uma arquivo o file composto por varias propriedades larguras, peso, nome, tipo de arquivo etc..

        if (arquivo) {
            let carregar = new FileReader();

            carregar.onload = function(e) {
                imgFoto.src = e.target.result;
            }

            carregar.readAsDataURL(arquivo);
        }
    })
</script>