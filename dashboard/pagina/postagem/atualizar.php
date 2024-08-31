<?php

require_once('class/ClassPostagem.php');
$id = $_GET['id'];
$postagem = new ClassPostagem($id);

if (isset($_POST['tituloPostagem'])) {
    $tituloPostagem = $_POST['tituloPostagem'];
    $categoriaPostagem = $_POST['categoriaPostagem'];
    $conteudoPostagem = $_POST['conteudoPostagem'];
    $statusPostagem = $_POST['statusPostagem'];
    $altPostagem = "foto " . $tituloPostagem;
    

    // Verificar se a foto foi modificada
    if (!empty($_FILES['fotoPostagem']['name'])) {
        // Tratar o campo FILES
        $arquivo = $_FILES['fotoPostagem'];
        if ($arquivo['error']) {
            throw new Exception('O erro foi: ' . $arquivo['error']);
        }

        $nomePosFoto = str_replace(' ', '', $tituloPostagem); // Remove os espaços em branco do nome
        $nomePosFoto = iconv('UTF-8', 'ASCII//TRANSLIT', $nomePosFoto); // Eliminação de caracteres especiais
        $nomePosFoto = strtolower($nomePosFoto); // Deixar tudo minúsculo

        // O novo nome da imagem
        $novoNome = $postagem->idPostagem . '_' . $nomePosFoto . '.jpeg';

        // Mover a imagem
        if (move_uploaded_file($arquivo['tmp_name'], 'img/postagem/' . $novoNome)) {
            $fotoPostagem = $novoNome;
        } else {
            throw new Exception('Não é possível realizar o upload.');
        }
    } else {
        $fotoPostagem = $postagem->fotoPostagem;
    }

    // Atualizar no banco de dados
    $postagem->tituloPostagem = $tituloPostagem;
    $postagem->altPostagem = $altPostagem;
    $postagem->categoriaPostagem = $categoriaPostagem;
    $postagem->fotoPostagem = $fotoPostagem; // Certifique-se de que esta linha está correta
    $postagem->statusPostagem = $statusPostagem;
    $postagem->conteudoPostagem = $conteudoPostagem;

    $postagem->Atualizar();
} // Aqui fecha o bloco if(isset($_POST['tituloPostagem']))
?>


<div class="container mt-5">
    <h2>Atualizar Postagem</h2>
    <form action="index.php?p=postagem&pos=atualizar&id=<?php echo $postagem->idPostagem; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">


            <!-- Seção de Dados da Postagem -->
            <div class="col-md-9">
                <div class="row mb-3">
                    <!-- Nome Funcionário -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="idFuncionario" class="form-label">Nome Funcionário</label>
                            <select class="form-select" id="idFuncionario" name="idFuncionario" required>
                                <option value="1" <?php echo ($funcionario->idFuncionario == '1') ? 'selected' : ''; ?>>Kakashi Hatake</option>
                                <option value="2" <?php echo ($funcionario->idFuncionario == '2') ? 'selected' : ''; ?>>Urahara Kisuke</option>
                                <option value="3" <?php echo ($funcionario->idFuncionario == '3') ? 'selected' : ''; ?>>Urokodaki Sakonji</option>
                                <option value="4" <?php echo ($funcionario->idFuncionario == '4') ? 'selected' : ''; ?>>All Might</option>
                                <option value="5" <?php echo ($funcionario->idFuncionario == '5') ? 'selected' : ''; ?>>Yami Sukehiro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Categoria Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="categoriaPostagem" class="form-label">Categoria Postagem</label>
                            <input type="text" class="form-control" id="categoriaPostagem" name="categoriaPostagem" placeholder="Categoria Postagem" required value="<?php echo $postagem->categoriaPostagem; ?>">
                        </div>
                    </div>

                    <!-- Título Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tituloPostagem" class="form-label">Título Postagem</label>
                            <input type="text" class="form-control" id="tituloPostagem" name="tituloPostagem" placeholder="Título Postagem" required value="<?php echo $postagem->tituloPostagem; ?>">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Status Postagem -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="statusPostagem" class="form-label">Status Postagem</label>
                            <select class="form-select" id="statusPostagem" name="statusPostagem" required>
                                <option value="PUBLICADO" <?php echo ($postagem->statusPostagem == 'PUBLICADO') ? 'selected' : ''; ?>>PUBLICADO</option>
                                <option value="INATIVO" <?php echo ($postagem->statusPostagem == 'INATIVO') ? 'selected' : ''; ?>>INATIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Conteúdo Postagem -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="conteudoPostagem" class="form-label">Conteúdo Postagem</label>
                            <textarea class="form-control" id="conteudoPostagem" name="conteudoPostagem" placeholder="Conteúdo Postagem" rows="4" required><?php echo $postagem->conteudoPostagem; ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="index.php?p=postagem" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
            <!-- Seção de Imagem -->
            <div class="col-md-3 mb-3">
                <img src="img/postagem/<?php echo $postagem->fotoPostagem; ?>" class="img-fluid" alt="foto da postagem" id="img">
                <input type="file" class="form-control" id="foto" name="foto" style="display: none;">
            </div>
        </div>
    </form>
</div>



