<?php



// iniciar processo cadastro do cliente ligado ao banco de dados
if (isset($_POST['tituloPostagem'])) {

    $tituloPostagem = $_POST['tituloPostagem'];
    $conteudoPostagem = $_POST['conteudoPostagem'];
    $categoriaPostagem = $_POST['categoriaPostagem'];
    $idFuncionario = $_POST['idFuncionario'];
    $statusPostagem = 'PUBLICADO';
    $altPostagem = "foto de " . $tituloPostagem;

    // Recuperar o ID
    require_once('class/Conexao.php');
    $conexao = Conexao::LigarConexao();
    $sql = $conexao->query('select idPostagem from postagem order by idPostagem  desc limit 1');
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

    if ($resultado !== false && isset($resultado['idPostagem'])) {

        $novoId = $resultado['idPostagem'] + 1;
    }

    //tratar o campo FILES (foto)
    $arquivo = $_FILES['fotoPostagem'];

    if ($arquivo['error']) {

        throw new Exception('O erro foi: ' . $arquivo['error']);
    }


    $nomePosFoto = str_replace(' ', '', $tituloPostagem); // remove os espaço em branco do nome cliente em relacao a foto dele
    $nomePosFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomePosFoto); // eliminação de caracteres especiais (sinais deacriticos)
    $nomePosFoto = strtolower($nomePosFoto); // deixar tudo minusculo

    // O novo nome da imagem
    $novoNome = $novoId . '_' . $nomePosFoto . '.jpeg';

    // print_r($novoNome);

    // Mover a IMG - para a pasta clientes que foi criada dentro de (dashboard/img/clientes)
    if (move_uploaded_file($arquivo['tmp_name'], 'img/postagem/' . $novoNome)) {

        $fotoPostagem  =  $novoNome;
    } else {
        throw new Exception('erroooooooo ferrou.');
    }

    require_once('class/ClassPostagem.php');

    $postagem = new ClassPostagem();

    $postagem->tituloPostagem  = $tituloPostagem;
    $postagem->fotoPostagem  = $fotoPostagem;
    $postagem->conteudoPostagem  = $conteudoPostagem;
    $postagem->statusPostagem  = $statusPostagem;
    $postagem->categoriaPostagem  = $categoriaPostagem;
    $postagem->altPostagem  = $altPostagem;
    $postagem->idFuncionario  = $idFuncionario;



    $postagem->Inserir();
}


?>


<div class="container mt-5">
    <h2>Cadastro de Postagens</h2>
    <form action="index.php?p=postagem&pos=inserir" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Seção de Imagem -->


            <!-- Seção de Dados da Postagem -->
            <div class="col-md-9">
                <div class="row mb-3">
                    <!-- Nome Funcionário -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="idFuncionario" class="form-label">Nome Funcionário</label>
                            <select class="form-select" id="idFuncionario" name="idFuncionario" required>
                                <option value="1">Kakashi Hatake</option>
                                <option value="2">Urahara Kisuke</option>
                                <option value="3">Urokodaki Sakonji</option>
                                <option value="4">All Might</option>
                                <option value="5">Yami Sukehiro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Categoria Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="categoriaPostagem" class="form-label">Categoria Postagem</label>
                            <input type="text" class="form-control" id="categoriaPostagem" name="categoriaPostagem" placeholder="Categoria Postagem" required>
                        </div>
                    </div>

                    <!-- Título Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tituloPostagem" class="form-label">Título Postagem</label>
                            <input type="text" class="form-control" id="tituloPostagem" name="tituloPostagem" placeholder="Título Postagem" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Status Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="statusPostagem" class="form-label">Status Postagem</label>
                            <select class="form-select" id="statusPostagem" name="statusPostagem" required>
                                <option value="PUBLICADO">PUBLICADO</option>
                                <option value="INATIVO">INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Conteúdo Postagem -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="conteudoPostagem" class="form-label">Conteúdo Postagem</label>
                            <textarea class="form-control" id="conteudoPostagem" name="conteudoPostagem" placeholder="Conteúdo Postagem" rows="4" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <a href="index.php?p=postagem" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <img src="img/postagem/semfoto.jpeg" class="img-fluid" alt="foto da postagem" id="img">
                <input type="file" class="form-control" id="foto" name="foto" style="display: none;">
            </div>
        </div>
    </form>
</div>


