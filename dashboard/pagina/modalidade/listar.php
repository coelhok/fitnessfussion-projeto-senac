<!-- chamando a clase com seus atributos e metodos-->
<?php
require_once('class/ClassModalidade.php');
$modalidade = new ClassModalidade();
$lista = $modalidade->Listar();
?>

<a class="btn btnCad" href="index.php?p=modalidade&m=inserir"> + Cadastrar Modalidade</a>

<div class="card">
    <div class="card-header">
        <h3>modalidade</h3>
    </div>

    <div class="card-body">
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <td scope="col">Foto</td>
                        <td scope="col">Nome</td>
                        <td scope="col">Conteudo</td>
                        <td scope="col">Status</td>
                        <td scope="col">Atualizar</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $linha) : ?> <!-- laço repetição-->
                        <tr>
                            <?php $linha['idModalidade']; ?>
                            <td><img src="img/modalidade/<?php echo $linha['fotoModalidade']; ?>" style="width: 100px; height: auto;"></td>
                            <td><?php echo $linha['nomeModalidade']; ?></td>
                            <td><?php echo $linha['conteudoModalidade']; ?></td>
                            <td><?php echo $linha['statusModalidade']; ?></td>
                            <td><a class="btn" href="index.php?p=modalidade&m=atualizar&id=<?php echo $linha['idModalidade']; ?>"><span class="las la-edit"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>