<!-- chamando a classe com seus atributos e métodos-->
<?php
require_once('class/ClassPostagem.php');
$postagem = new ClassPostagem();
$lista = $postagem->Listar();
?>

<a class="btn btnCad" href="index.php?p=postagem&pos=inserir"> + Cadastrar Postagem</a>

<div class="card">
    <div class="card-header">
        <h3>Postagem</h3>
    </div>

    <div class="card-body">
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <td scope="col">Foto</td>
                        <td scope="col">Título</td>
                        <td scope="col">Autor</td>
                        <td scope="col">Status</td>
                        <td scope="col">Visualizações</td>
                        <td scope="col">Categoria</td>
                        <td scope="col">Data</td>
                        <td scope="col">Atualizar</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $linha) : ?>
                        <tr>
                            <td><img src="img/postagem/<?php echo $linha['fotoPostagem']; ?>" alt="<?php echo $linha['altPostagem']; ?>"></td>
                            <td><?php echo $linha['tituloPostagem']; ?></td>
                            <td><?php echo $linha['nomeFuncionario']; ?></td>
                            <td><?php echo $linha['statusPostagem']; ?></td>
                            <td><?php echo $linha['visualizacoesPostagem']; ?></td>
                            <td><?php echo $linha['categoriaPostagem']; ?></td>
                            <td><?php echo $linha['dataPostagem']; ?></td>
                            <td><a class="btn" href="index.php?p=postagem&pos=atualizar&id=<?php echo $linha['idPostagem']; ?>"><span class="las la-edit"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>