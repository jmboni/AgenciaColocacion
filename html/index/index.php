<?php include(HTML_DIR . 'overall/header.php'); ?>

<body>
<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar">
    <div class="mbr-section__container container mbr-section__container--isolated">

        <?php
        if(isset($_GET['success'])) {
            echo '<div class="alert alert-dismissible alert-success">
      <strong>Activado!</strong> tu usuario ha sido activado correctamente.
    </div>';
        }
        if(isset($_GET['error'])) {
            echo '<div class="alert alert-dismissible alert-danger">
      <strong>Error!</strong></strong> no se ha podido activar tu usuario.
    </div>';
        }
        ?>

        <div class="row container">

            <?php
            if(isset($_SESSION['app_id']) and $_users[$_SESSION['app_id']]['permisos'] >= 2) {
                echo '
          <div class="pull-right">
            <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
              <a class="mbr-buttons__btn btn btn-danger" href="?view=configofertas">GESTIONAR OFERTAS</a>
            </li></ul></div>
            <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
              <a class="mbr-buttons__btn btn btn-danger" href="?view=categorias">GESTIONAR CATEGORÍAS</a>
            </li></ul></div>
          </div>
          ';
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="?view=index"><i class="fa fa-home"></i> Inicio</a></li>
            </ol>
        </div>

        <?php
        if(false != $_categorias) {
            $prepare_sql = $db->prepare("SELECT id FROM ofertas WHERE id_categoria = ? ;");
            $prepare_sql->bind_param('i',$id_categoria);
            foreach($_categorias as $id_categoria => $array_categoria) {
                $prepare_sql->execute();
                $prepare_sql->store_result();
                echo '<div class="row categorias_con_foros">
      <div class="col-sm-12">
          <div class="row titulo_categoria">'.$_categorias[$id_categoria]['nombre'].'</div>';
                if($prepare_sql->num_rows > 0) {
                    $prepare_sql->bind_result($id_de_oferta);
                    while($prepare_sql->fetch()) {
                        if($_ofertas[$id_de_oferta]['estado'] == 1) {
                            $extension = '.png';
                        } else {
                            $extension = '_bloqueado.png';
                        }
                        echo '<div class="row foros">
          <div class="col-md-1" style="height:50px;line-height: 37px;">
            <img src="views/app/images/foros/foro_leido'.$extension.'" />
          </div>
          <div class="col-md-7 puntitos" style="padding-left: 0px;">
            <a href="ofertas/'.UrlAmigable($id_de_oferta,$_ofertas[$id_de_oferta]['nombre']).'">'.$_ofertas[$id_de_oferta]['nombre'].'</a><br />
            '.$_ofertas[$id_de_oferta]['descripcion'].'
          </div>
          <div class="col-md-2 left_border" style="text-align: center;font-weight: bold;">
            '.$_ofertas[$id_de_oferta]['cantidad_ofertas'].' Ofertas<br />
            '.$_ofertas[$id_de_oferta]['cantidad_temas'].' Mensajes
          </div>
          <div class="col-md-2 left_border puntitos" style="line-height: 37px;">
            <a href="#">Ultimo mensaje acá texto largo</a>
          </div>
        </div>';
                    }
                } else {
                    echo '<div class="row foros">
          <div class="col-md-12" style="height:50px;line-height: 37px;">
            No existe ninguna oferta.
          </div>
        </div>';
                }
                echo '</div>
      </div>';
            }
            $prepare_sql->close();
        } else {
            echo '<div class="row categorias_con_foros">
    <div class="col-sm-12">
        <div class="row titulo_categoria">'. APP_TITLE . '</div>
        <div class="row foros">
          <div class="col-md-12" style="height:50px;line-height: 37px;">
            No existe ninguna categoría
          </div>
        </div>
    </div>
  </div>';
        }
        ?>

    </div>
</section>


<?php include(HTML_DIR . 'overall/footer.php'); ?>

</body>
</html>