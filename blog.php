<!-- CONTEUDO REVISADO/ACESSIBILIDADE CHECADA-->
<!--Enviar Email-->
<?php

// Importar classes do PHPMailer para o espaço de nomes global
// Estas devem estar no topo do seu script, não dentro de uma função
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$ok = 0;

if (isset($_POST['email'])) {

  $nome   = $_POST['nome'];
  $email  = $_POST['email'];

  // Carregar o autoloader do Composer
  require 'mailer/Exception.php';
  require 'mailer/PHPMailer.php';
  require 'mailer/SMTP.php';

  // Criar uma instância; passar `true` habilita exceções
  $mail = new PHPMailer(true);

  try {
    // Configurações do servidor
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Desativar a saída de depuração detalhada
    $mail->isSMTP();                                            // Enviar usando SMTP
    $mail->Host       = 'smtp.hostinger.com';                   // Definir o servidor SMTP para enviar
    $mail->SMTPAuth   = true;                                   // Habilitar autenticação SMTP
    $mail->Username   = 'fitnessfusion@ti22.smpsistema.com.br';             // Nome de usuário SMTP
    $mail->Password   = 'Senac@fitnessfusion01';               // Senha SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Habilitar criptografia TLS
    $mail->Port       = 465;                                    // Porta TCP para conectar-se

    // Destinatários
    $mail->setFrom('fitnessfusion@ti22.smpsistema.com.br', 'Fitness Fusion');
    $mail->addAddress('fitnessfusion@ti22.smpsistema.com.br');               // Adicionar um destinatário

    // Conteúdo
    $mail->isHTML(true);                                        // Definir formato de e-mail para HTML
    $mail->Subject = 'Newslatter Fitness Fusion';

    $mail->Body    = "
            <strong> Mensagem do site Fitness Fusion </strong>
            <br><br>
            <strong> Nome: </strong> $nome <br>
            <strong> Email: </strong> $email <br>
        ";

    $mail->AltBody = "
        Novo Assinante Newlatter
            \n\n
            Nome: $nome \n
            Email: $email \n
        ";

    $mail->send();
    $ok = 1;
  } catch (Exception $e) {
    $ok = 2;
    echo "Erro do Mailer: {$mail->ErrorInfo}";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Equipe GKR">
  <meta name="description" content="A Academia Fitness Fusion: Inspire-se. Transpire. Conquiste.">
  <link rel="icon" href="img/logo/logoFitnessvazio.svg" type="image/svg+xml">
  <title>Blog - Academia Fitness Fusion</title>
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
  <!--############# Começo do menu ###########-->

  <header>
    <div id="menu-fixo" class="menu">
      <div>
        <!-- Logo com link para a página inicial -->
        <a href="index.php" aria-label="Voltar para a página inicial">
          <h1 class="logo" aria-hidden="true">Blog - Academia Fitness Fusion</h1>
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
            <li><a href="modalidade.php">modalidade</a></li>
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

  <!-- CONTEUDO BLOG -->
  <main>
    <article>

      <div class="conteudoBlog">

        <h2 class="titulo" onclick="window.location.href='blog.php';">Fusion Flow/Em desenvolvimento
        </h2>

        <h5>
          <?php
          if ($ok == 1) {
            echo "Parabéns " . $nome . " agora você é um Flow Followers !";
          } else if ($ok == 2) {
            $nome . ", não foi possivel realizar sua Assinatura :/ tente novamente em alguns minutos";
          }
          ?>
        </h5>

        <div>

          <section class="postagem">

            <div>

              <div class="wow animate__animated animate__fadeInBottomLeft">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Os Benefícios do Treinamento de Força para a Saúde
                </h2>

                <p>
                  Esta postagem explora os inúmeros benefícios do treinamento de força para a saúde física e mental, incluindo o aumento da força muscular, a melhoria da densidade óssea e a redução do risco de doenças crônicas. Também destacamos a importância de incorporar exercícios de resistência em sua rotina de academia.
                </p>

                <h3>
                  Autor: Amanda Silva
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    10 de abril de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    152
                  </h4>

                </div>

                <div>

                  <h5>
                    Treino
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Os Benefícios do Treinamento de Força para a Saúde'">Ler Mais</a>

                </div>

              </div>

              <div class="wow animate__animated animate__fadeInBottomLeft">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Como Montar um Programa de Treino Eficiente
                </h2>

                <p>
                  Nesta postagem, discutimos os principais elementos a serem considerados ao montar um programa de treino eficaz, incluindo metas pessoais, frequência de treino, divisão de grupos musculares e progressão. Oferecemos dicas práticas para ajudar os leitores a maximizar seus resultados na academia.
                </p>

                <h3>
                  Autor: João Santos
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    15 de abril de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    98
                  </h4>

                </div>

                <div>

                  <h5>
                    Treino
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Como Montar um Programa de Treino Eficiente'">Ler Mais</a>

                </div>

              </div>

              <div class="wow animate__animated animate__fadeInBottomRight">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Os Mitos Mais Comuns Sobre Exercício Físico
                </h2>

                <p>
                  Nesta postagem, desmascaramos alguns dos mitos mais comuns relacionados ao exercício físico, como a ideia de que é necessário passar horas na academia todos os dias para ver resultados significativos. Oferecemos informações precisas e baseadas em evidências para ajudar os leitores a separar fatos de ficção quando se trata de fitness.
                </p>

                <h3>
                  Autor: Carla Mendes
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    20 de abril de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    205
                  </h4>

                </div>

                <div>

                  <h5>
                    Informação
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Os Mitos Mais Comuns Sobre Exercício Físico'">Ler Mais</a>

                </div>


              </div>

              <div class="wow animate__animated animate__fadeInBottomRight">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Alimentação Saudável: O Papel Fundamental na Performance na Academia
                </h2>

                <p>
                  Nesta postagem, exploramos a importância de uma alimentação saudável para otimizar a performance na academia. Discutimos a relação entre nutrição e recuperação muscular, energia durante os treinos e composição corporal. Oferecemos dicas práticas para uma dieta equilibrada que apoie os objetivos de fitness.
                </p>

                <h3>
                  Autor: Rafaela Oliveira
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    25 de abril de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    124
                  </h4>

                </div>

                <div>

                  <h5>
                    Nutrição
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Alimentação Saudável: O Papel Fundamental na Performance na Academia'">Ler Mais</a>

                </div>

              </div>

            </div>

            <div>

              <div class="wow animate__animated animate__fadeInBottomLeft">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Os Melhores Exercícios para Queimar Calorias
                </h2>

                <p>
                  Nesta postagem, destacamos uma variedade de exercícios eficazes para queimar calorias e promover a perda de peso. Incluímos exercícios cardiovasculares e de treinamento de força que aceleram o metabolismo e ajudam os leitores a atingir seus objetivos de condicionamento físico. Também fornecemos orientações sobre como incorporar esses exercícios em uma rotina de treino.
                </p>

                <h3>
                  Autor: Pedro Martins
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    30 de abril de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    178
                  </h4>

                </div>

                <div>

                  <h5>
                    Emagrecimento
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Os Melhores Exercícios para Queimar Calorias'">Ler Mais</a>

                </div>

              </div>

              <div class="wow animate__animated animate__fadeInBottomLeft">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  A Importância do Descanso na Recuperação Muscular
                </h2>

                <p>
                  Nesta postagem, discutimos a importância do descanso adequado na recuperação muscular e no progresso na academia. Explicamos como o sono de qualidade, os dias de descanso e as técnicas de recuperação ativa podem melhorar a performance e prevenir lesões. Oferecemos conselhos sobre como incorporar o descanso adequado em uma rotina de treino.
                </p>

                <h3>
                  Autor: Mariana Costa
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    5 de maio de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    142
                  </h4>

                </div>

                <div>

                  <h5>
                    Saúde
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'A Importância do Descanso na Recuperação Muscular'">Ler Mais</a>

                </div>

              </div>

              <div class="wow animate__animated animate__fadeInBottomRight">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Dicas para Evitar Lesões na Academia
                </h2>

                <p>
                  Nesta postagem, compartilhamos dicas práticas para ajudar os leitores a evitar lesões durante os treinos na academia. Discutimos a importância do aquecimento adequado, da técnica correta de exercícios e do alongamento para prevenir lesões musculares e articulares. Também enfatizamos a importância de ouvir o corpo e respeitar os limites individuais.
                </p>

                <h3>
                  Autor: Carlos Oliveira
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    10 de maio de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    113
                  </h4>

                </div>

                <div>

                  <h5>
                    Segurança
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Dicas para Evitar Lesões na Academia'">Ler Mais</a>

                </div>

              </div>

              <div class="wow animate__animated animate__fadeInBottomRight">

                <img src="img/blog/fff.png" alt="FOTO CONTEUDO BLOG" aria-hidden="true">

                <h2>
                  Motivação na Academia: Como Manter-se Comprometido com seus Objetivos
                </h2>

                <p>
                  Nesta postagem, oferecemos estratégias eficazes para manter a motivação e o comprometimento com os objetivos de fitness na academia. Discutimos a importância de estabelecer metas realistas, encontrar um parceiro de treino, variar a rotina de exercícios e celebrar as conquistas ao longo do caminho. Inspiramos os leitores a perseverar em sua jornada de condicionamento físico.
                </p>

                <h3>
                  Autor: Ana Rodrigues
                </h3>

                <div>

                  <h4>
                    <span class="material-symbols-outlined">calendar_month</span>
                    15 de maio de 2024
                  </h4>

                  <h4>
                    <span class="material-symbols-outlined">visibility</span>
                    189
                  </h4>

                </div>

                <div>

                  <h5>
                    Motivação
                  </h5>

                  <a class="btn" href="blog.php" role="button" aria-label="Saiba mais sobre 'Motivação na Academia: Como Manter-se Comprometido com seus Objetivos'">Ler Mais</a>
                </div>

              </div>

            </div>

          </section>

          <section class="newslatter">

            <div class="wow animate__animated animate__slideInRight">

              <img src="img/blog/newslatter.png" alt="Foto Newslatter: Mulher saltanto em cima do seguinte texto: Motivação para esmagar a preguiça">

              <h2>
                Assine a Newslatter Fusion Flow
              </h2>

              <p>
                e conte com Benefícios Incriveis:
              </p>

              <ul>

                <li>
                  1° Fique por dentro das novas aulas, horários, eventos e workshops oferecidos pela academia.
                </li>

                <li>
                  2° Receba conselhos práticos sobre nutrição, exercícios e estilos de vida saudáveis para manter ou melhorar seu bem-estar.
                </li>

                <li>
                  3° A newsletter inclui histórias inspiradoras de sucesso, desafios ou dicas motivacionais para mantê-lo engajado em sua jornada fitness.
                </li>

                <li>
                  4° Aproveite ofertas e descontos exclusivos para assinantes, seja em aulas, produtos ou serviços da academia.
                </li>

              </ul>

              <form action="blog.php" method="post">

                <h2>O que achou? Assine nosso Newsletter</h2>

                <input type="text" name="nome" placeholder="Seu Nome" required>
                <input type="email" name="email" placeholder="Seu E-mail" required>
                <input type="submit" value="Assinar">

              </form>

            </div>

          </section>

        </div>

      </div>

    </article>

  </main>

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