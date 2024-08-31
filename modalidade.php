<?php
require_once('dashboard/class/Conexao.php');
require_once('dashboard/class/ClassEvento.php');
require_once('dashboard/class/ClassModalidade.php');
$evento = new ClassEvento();
$modalidade = new ClassModalidade();

// Conexão com o banco de dados
$conexao = Conexao::LigarConexao();

// Buscar modalidade com status SITE
$sql = $conexao->query("SELECT
                m.nomeModalidade,
                m.fotoModalidade,
                m.altModalidade
            FROM
                modalidade m
            WHERE statusModalidade = 'ATIVO' or statusModalidade = 'SITE'");
$modalidade = $sql->fetchAll(PDO::FETCH_ASSOC);

$lista = $evento->listar(); // Supondo que listar() retorna a lista de eventos

$eventos = [];
foreach ($lista as $linha) {
  $evento = [
    'id' => $linha['idEvento'] ?? '',
    'name' => $linha['nomeEvento'] ?? '',
    'date' => isset($linha['dataEvento']) ? date('F d, Y', strtotime($linha['dataEvento'])) : '',
    'type' => 'event',
  ];
  $eventos[] = $evento;
}
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
  <title>Modalidade - Academia Fitness Fusion</title>
  <!--############# Links/Referencias ##################-->
  <!--############# RESETA ##################-->
  <link rel="stylesheet" href="css/reset.css">
  <!--############# GOOGLE ##################-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!--############# SLICK ##################-->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/slick-theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!--############# CALENDARIO ##################-->
  <link rel="stylesheet" href="css/evo-calendar.css" />
  <link rel="stylesheet" href="css/evo-calendar.midnight-blue.css" />
  <!--############# ESTILO ##################-->
  <link rel="stylesheet" href="css/style.css">
  <!--############# RESPONSIVO ##################-->
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
  <!--############# Começo do menu ###########-->
  <header>
    <div id="menu-fixo" class="menu">
      <div>
        <!-- Logo com link para a página inicial -->
        <a href="index.php" aria-label="Voltar para a página inicial">
          <h1 class="logo" aria-hidden="true">Modalidade - Academia Fitness Fusion</h1>
        </a>

        <!-- Botão de menu para abrir o menu de navegação -->
        <label id="menu" class="hamburger">
          <input type="checkbox" id="menuCheckbox">
          <svg viewBox="0 0 32 32">
            <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
            <path class="line" d="M7 16 27 16"></path>
          </svg>
        </label>

        <nav class="navegacao" aria-label="Menu de navegação principal">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="sobre.php">Sobre</a></li>
            <li><a href="modalidade.php">Modalidade</a></li>
            <li><a href="blog.php" class="las la-wrench">Blog</a></li>
            <li><a href="planos.php">Planos</a></li>
            <li><a href="contato.php">Contato</a></li>
          </ul>

          <div class="btn">
            <span class="material-symbols-outlined" aria-hidden="true">group</span>
            <a class="areaAluno" href="login.php" role="button" aria-label="Área do Aluno">Área Do Usuário</a>
          </div>
        </nav>
      </div>
    </div>
  </header>
  <!--########### fim do menu ##########-->
  <!--########### CONTEUDO ##########-->
  <main>
    <article>
      <img class="banner" src="img/banner/bannerModalidade.jpeg" alt="Banner Modalidade" aria-hidden="true">
      <h3 class="tituloSobreBanner wow animate__animated animate__zoomIn">modalidade</h3>
    </article>
    <!--############# Começo do menu ###########-->
    <div class="corpoModalidade">
      <aside class="wow animate__animated animate__fadeInLeft">
        <h2 class="titulo">Modalidade</h2>
        <nav class="sidebar" aria-label="Menu de modalidade">
          <ul class="modalidadeHover">
            <?php foreach ($modalidade as $linha) : ?> <!-- laço repetição-->
              <li><a href="#"><?php echo $linha['nomeModalidade']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </aside>
      <main>
        <ul class="fotoModalidade">
          <?php foreach ($modalidade as $linha) : ?> <!-- laço repetição-->
            <li class="wow animate__animated animate__slideInRight">
              <a href="#">
                <img src="dashboard/img/modalidade/<?php echo $linha['fotoModalidade']; ?>" alt="<?php echo $linha['altModalidade']; ?>">
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </main>
    </div>
    <h2 class="titulo wow animate__animated animate__fadeInUp">Eventos</h2>
    <div class="wow animate__animated animate__fadeInUp" id="calendar"></div>
  </main>


  <?php require_once('conteudo/rodape.php'); ?><!-- ###### RODAPÉ ########## -->

  <!--######### BIBLIOTECAS #########-->
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- SLICK JS -->
  <script src="js/slick.min.js"></script>
  <!-- WOW -->
  <script src="js/wow.min.js"></script>
  <!-- Calendario -->
  <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
  <!-- JS -->
  <script src="js/animacoes.js"></script>
  <script>
    $(document).ready(function() {
      let eventos = <?php echo json_encode($eventos); ?>;

      $("#calendar").evoCalendar({
        theme: "Midnight Blue",
        language: "pt",
        format: "dd MM, yyyy",
        titleFormat: "MM",
        todayHighlight: true,
        sidebarDisplayDefault: false,
        eventDisplayDefault: true,
        eventListToggler: true,
        calendarEvents: eventos,
      });
    });
  </script>
</body>

</html>