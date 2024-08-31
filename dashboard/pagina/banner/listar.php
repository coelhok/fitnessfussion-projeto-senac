<!-- chamando a clase com seus atributos e metodos-->
<?php
require_once('class/ClassBanner.php');
$banner = new ClassBanner();
$lista = $banner->Listar();
?>

<a class="btn btnCad" href="index.php?p=banner&b=inserir"> + Cadastrar Banner</a>

<div class="card">
    <div class="card-header">
        <h3>Banner</h3>
    </div>

    <div class="card-body">
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <td scope="col">Foto</td>
                        <td scope="col">Nome</td>
                        <td scope="col">Status</td>
                        <td scope="col">tipo</td>
                        <td scope="col">Atualizar</td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $linha) : ?> <!-- laço repetição-->
                        <tr>
                            <?php $linha['idBanner']; ?>
                            <td><img src="img/banner/<?php echo $linha['fotoBanner']; ?>" style="width: 100px; height: auto;"></td>
                            <td><?php echo $linha['nomeBanner']; ?></td>
                            <td><?php echo $linha['statusBanner']; ?></td>
                            <td><?php echo $linha['tipoBanner']; ?></td>
                            <td><a class="btn" href="index.php?p=banner&b=atualizar&id=<?php echo $linha['idBanner']; ?>"><span class="las la-edit"></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>