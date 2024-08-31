<?php
require_once('class/ClassCliente.php');
$cliente = new ClassCliente();
$lista = $cliente->Listar();

// Recuperar o ID
require_once('class/Conexao.php');
$conexao = Conexao::LigarConexao();

$sql = $conexao->query("SELECT COUNT(idCliente) AS totalAtivos FROM cliente WHERE statusCliente = 'ATIVO';");
$ativos = $sql->fetch(PDO::FETCH_ASSOC);

$sql = $conexao->query("SELECT COUNT(idCliente) AS totalInativos FROM cliente WHERE statusCliente = 'INATIVO';");
$inativos = $sql->fetch(PDO::FETCH_ASSOC);

// Buscar os últimos clientes cadastrados
$sql = $conexao->query("SELECT     
                c.nomeCliente,
                c.fotoCliente,
                c.altCliente,
                c.telefoneCliente,
                p.nomePlano
            FROM
                cliente c
            INNER JOIN
                planoAssinatura p ON c.idPlano = p.idPlano
            WHERE
                c.statusCliente = 'ATIVO'
            ORDER BY
                c.dataCadCliente DESC
            LIMIT 5");
$novosClientes = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- CONTEUDO DASH -->
<section>
    <div class="dadoPrimario">
        <div> <!-- Clientes -->
            <div>
                <img src="img/cliente.png" alt="Icone Cliente">
            </div>
            <div>
                <h2>
                    <?php echo $ativos['totalAtivos']; ?>
                </h2>
                <h3>
                    Clientes
                </h3>
            </div>
        </div><!-- FIM Clientes -->

        <div> <!-- Visualizações Blog -->
            <div>
                <img src="img/visualizacoes.png" alt="Icone Visualizações do Blog">
            </div>
            <div>
                <h2>
                    5.326
                </h2>
                <h3>
                    Visualizações
                </h3>
                <small>
                    (30 dias)
                </small>

            </div>

        </div> <!-- FIM Visualizações Blog -->

        <div> <!-- Matriculas canceladas -->

            <div>
                <img src="img/contrato.png" alt="Icone Matriculas Canceladas">
            </div>
            <div>
                <h2>
                    <?php echo $inativos['totalInativos']; ?>
                </h2>
                <h3>
                    Matriculas canceladas
                </h3>
            </div>

        </div> <!-- FIM Matriculas canceladas -->

        <div> <!-- Receita mensal -->
            <div>
                <img src="img/receita.png" alt="Icone Receita Mensal">
            </div>
            <div>
                <h2>
                    37.500,99
                </h2>
                <h3>
                    Receita mensal
                </h3>
                <small>
                    (30 dias)
                </small>
            </div>

        </div> <!-- FIM Receita mensal -->
    </div>
</section>
<!-- AREA CLiENTE -->
<section>
    <div class="cliente">
        <div class="card">
            <div class="card-header">
                <h3>Alunos</h3>
            </div>

            <div class="card-body">
                <div class="tabelaDash">
                    <table>
                        <thead>
                            <tr>
                                <td scope="col">Foto</td>
                                <td scope="col">Nome</td>
                                <td scope="col">Plano</td>
                                <td scope="col">Telefone</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $linha) : ?> <!-- laço repetição-->
                                <tr>
                                    <?php $linha['idCliente']; ?>
                                    <td><img src="img/cliente/<?php echo $linha['fotoCliente']; ?>" alt="<?php echo $linha['altCliente']; ?>"></td>
                                    <td><?php echo $linha['nomeCliente']; ?></td>
                                    <td><?php echo $linha['nomePlano']; ?></td>
                                    <td><?php echo $linha['telefoneCliente']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="customers">
            <div class="card">
                <div class="card-header">
                    <h3>Novos alunos</h3>
                </div>
                <div class="card-body">
                    <?php foreach ($novosClientes as $cliente) : ?>
                        <div class="customer">
                            <div class="info">
                                <img src="img/cliente/<?php echo $cliente['fotoCliente']; ?>" alt="<?php echo $cliente['altCliente']; ?>">
                                <div>
                                    <h4><?php echo $cliente['nomeCliente']; ?></h4>
                                    <h4><?php echo $cliente['telefoneCliente']; ?></h4>
                                </div>
                            </div>
                            <div>
                                <h4><?php echo $cliente['nomePlano']; ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- GRAFICOS -->
<section>
    <div class="grafico">
        <div>
            <canvas id="grafico1"></canvas>
        </div>
        <div>
            <canvas id="grafico2"></canvas>
        </div>
    </div>
</section>

<!-- FIM GRAFICOS -->