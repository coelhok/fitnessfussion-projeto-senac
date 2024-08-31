<?php

    $pagina = @$_GET['feed'];

    if ($pagina == NULL) {
        
        require_once('listar.php');

    }else{

            if($pagina == 'inserir'){require_once('inserir.php'); }
            if($pagina == 'atualizar'){require_once('atualizar.php'); }

    }

?>