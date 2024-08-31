<!-- chamando a clase com seus atributos e metodos-->
<?php
require_once('class/ClassCliente.php');
$cliente = new ClassCliente();
$lista = $cliente->Listar();

?>

<a class="btn btnCad" href="index.php?p=aluno&c=inserir"> + Cadastrar Aluno</a>

<div class="card">
    <div class="card-header">
        <h3>Alunos</h3>
    </div>

    <div class="card-body">
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <td scope="col">Foto</td>
                        <td scope="col">Nome</td>
                        <td scope="col">Plano</td>
                        <td scope="col">E-mail</td>
                        <td scope="col">Telefone</td>
                        <td scope="col">Atualizar</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $linha) : ?> <!-- laço repetição-->
                        <tr>
                            <?php $linha['idCliente']; ?>
                            <td><img src="img/cliente/<?php echo $linha['fotoCliente']; ?>" alt="<?php echo $linha['altCliente']; ?>"></td>
                            <td><?php echo $linha['nomeCliente']; ?></td>
                            <td><?php echo $linha['nomePlano']; ?></td>
                            <td><?php echo $linha['emailCliente']; ?></td>
                            <td><?php echo $linha['telefoneCliente']; ?></td>
                            <td><a class="btn btn" href="index.php?p=aluno&c=atualizar&id=<?php echo $linha['idCliente']; ?>"><span class="las la-edit"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>