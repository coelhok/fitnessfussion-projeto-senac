<?php
require_once('dashboard/class/ClassBanner.php');
require_once('dashboard/class/ClassModalidade.php');
require_once('dashboard/class/Conexao.php');

// Criar instâncias das classes
$banner = new ClassBanner();
$modalidade = new ClassModalidade();

// Conexão com o banco de dados
$conexao = Conexao::LigarConexao();

// Buscar modalidade com status SITE
$sql = $conexao->query("SELECT
                m.nomeModalidade,
                m.fotoModalidade,
                m.altModalidade,
                m.statusModalidade,
                m.conteudoModalidade
            FROM
                modalidade m
            WHERE
                m.statusModalidade = 'SITE'");
$modalidade = $sql->fetchAll(PDO::FETCH_ASSOC);

// Buscar banners principais com status ATIVO
$sql = $conexao->query("SELECT
                b.nomeBanner,
                b.fotoBanner,
                b.altBanner,
                b.statusBanner
            FROM
                banner b
            WHERE
                b.tipoBanner = 'PRINCIPAL' AND b.statusBanner = 'ATIVO'");
$bannersPrincipais = $sql->fetchAll(PDO::FETCH_ASSOC);

// Buscar banners secundários com status ATIVO
$sql = $conexao->query("SELECT
                b.nomeBanner,
                b.fotoBanner,
                b.altBanner,
                b.statusBanner
            FROM
                banner b
            WHERE
                b.tipoBanner = 'SECUNDARIO' AND b.statusBanner = 'ATIVO'");
$bannersSecundarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- CONTEUDO REVISADO/ACESSIBILIDADE CHECADA-->
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Equipe GKR">
  <meta name="description" content="A Academia Fitness Fusion: Inspire-se. Transpire. Conquiste.">
  <link rel="icon" href="img/logo/logoFitnessvazio.svg" type="image/svg+xml">
  <title>Home - Academia Fitness Fusion</title>
  <!--############# Links/Referencias ##################-->
  <!--############# RESETA ##################-->
  <link rel="stylesheet" href="css/reset.css">
  <!--############# GOOGLE ##################-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!--############# SLICK ##################-->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/slick-theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!--############# ESTILO ##################-->
  <link rel="stylesheet" href="css/style.css">
  <!--############# RESPONSIVO ##################-->
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body>

  <!--############ CABEÇALHO ##########-->

  <?php require_once('conteudo/topo.php'); ?>

  <!--############ FIM CABEÇALHO ##########-->
  <!--############ CONTEUDO ##########-->
  <main>

    <article><!--############ BANNER ##########-->
      <div class="banner">
        <?php foreach ($bannersPrincipais as $linha) : ?> <!-- laço repetição-->
          <img src="dashboard/img/banner/<?php echo $linha['fotoBanner']; ?>" alt="<?php echo $linha['altBanner']; ?>">
        <?php endforeach; ?>
      </div>
    </article>

    <?php require_once('conteudo/cont-sobre.php'); ?><!--######### SOBRE #########-->

    <?php require_once('conteudo/cont-modalidade.php'); ?><!--####### modalidade #########-->

    <article><!--####### BANNER EVENTOS #######-->
      <div class="banner">
        <?php foreach ($bannersSecundarios as $linha) : ?> <!-- laço repetição-->
          <img src="dashboard/img/banner/<?php echo $linha['fotoBanner']; ?>" alt="<?php echo $linha['altBanner']; ?>">
        <?php endforeach; ?>
      </div>
    </article>

    <?php require_once('conteudo/cont-blog.php'); ?><!--####### BLOG #######-->

    <?php require_once('conteudo/cont-planos.php'); ?><!-- ######### PLANOS ########## -->

    <?php require_once("conteudo/cont-comenterios.php"); ?><!-- ######### Comentarios ########## -->

  </main>
  <!--############ FIM CONTEUDO ##########-->

  <?php require_once('conteudo/rodape.php'); ?><!-- ###### RODAPÉ ########## -->

  <!--######### BIBLIOTECAS #########-->
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- SLICK JS -->
  <script src="js/slick.min.js"></script>
  <!-- WOW -->
  <script src="js/wow.min.js"></script>
  <!-- JS -->
  <script src="js/animacoes.js"></script>

</body>

</html>