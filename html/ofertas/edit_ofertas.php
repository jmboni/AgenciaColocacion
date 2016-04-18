<?php include(HTML_DIR . 'overall/header.php'); ?>

<body>
<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar">
    <div class="mbr-section__container container mbr-section__container--isolated">

        <?php
        if(isset($_GET['success'])) {
            echo '<div class="alert alert-dismissible alert-success">
      <strong>Completado!</strong> la oferta ha sido creada.
    </div>';
        }
        if(isset($_GET['error'])) {
            if($_GET['error'] == 1) {
                echo '<div class="alert alert-dismissible alert-danger">
        <strong>Error!</strong></strong> todos los campos deben estar llenos.
      </div>';
            } else {
                echo '<div class="alert alert-dismissible alert-danger">
        <strong>Error!</strong></strong> debe existir una categoría para asociar a la oferta.
      </div>';
            }
        }
        ?>

        <div class="row container">
            <div class="pull-right">
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=configofertas">GESTIONAR OFERTA</a>
                        </li></ul></div>
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=configofertas&mode=add">CREAR OFERTA</a>
                        </li></ul></div>
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=categorias">GESTIONAR CATEGORÍAS</a>
                        </li></ul></div>
            </div>

            <ol class="breadcrumb">
                <li><a href="?view=index"><i class="fa fa-comments"></i> Foros</a></li>
            </ol>
        </div>

        <div class="row categorias_con_foros">
            <div class="col-sm-12">
                <div class="row titulo_categoria">Gestión de Ofertas</div>

                <div class="row cajas">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="?view=configofertas&mode=edit&id=<?php echo $_GET['id'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Nombre</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" maxlength="250" name="nombre" placeholder="Nombre para el foro" value="<?php echo $_ofertas[$_GET['id']]['nombre'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Descripción</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" maxlength="250" name="descripcion" placeholder="Descripción corta (acepta HTML)" value="<?php echo $_ofertas[$_GET['id']]['descripcion'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Categoría</label>
                                    <div class="col-lg-10">
                                        <select name="categoria" class="form-control">
                                            <?php
                                            foreach($_categorias as $id_categoria => $array_categoria) {
                                                if($id_categoria == $_ofertas[$_GET['id']]['id_categoria']) {
                                                    echo '<option value="'.$id_categoria.'" selected>'.$_categorias[$id_categoria]['nombre'].'</option>';
                                                } else {
                                                    echo '<option value="'.$id_categoria.'">'.$_categorias[$id_categoria]['nombre'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Estado del foro</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="estado" value="1" <?php if($_ofertas[$_GET['id']]['estado'] == 1) { echo 'checked=""'; } ?>>
                                                Abierto
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="estado" value="0" <?php if($_ofertas[$_GET['id']]['estado'] == 0) { echo 'checked=""'; } ?>>
                                                Cerrado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="reset" class="btn btn-default">Resetear</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include(HTML_DIR . 'overall/footer.php'); ?>

</body>
</html>