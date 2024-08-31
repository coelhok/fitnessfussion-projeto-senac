<article>
  <div class="modalidade">
    <div class="site">
      <h2 class="wow animate__animated animate__zoomIn titulo" onclick="window.location.href='modalidade.php';" aria-label="Ir para modalidade">modalidade</h2>
      <div class="boxmodalidade">
        <?php foreach ($modalidade as $linha) : ?> <!-- laço repetição-->
          <div class="wow animate__animated animate__zoomIn">
            <img src="dashboard/img/modalidade/<?php echo $linha['fotoModalidade']; ?>" alt="<?php echo $linha['altModalidade']; ?>">
            <h3><?php echo $linha['nomeModalidade']; ?></h3>
            <p><?php echo $linha['conteudoModalidade']; ?></p>
            <a class="btn btn-mod" href="modalidade.php" aria-label="Ler mais sobre <?php echo $linha['altModalidade']; ?>">Ler Mais</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</article>