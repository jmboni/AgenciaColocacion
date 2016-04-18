<?php include(HTML_DIR . 'overall/header.php'); ?>

<body>
<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar">
    <div class="mbr-section__container container mbr-section__container--isolated">

        <?php
        if(isset($_GET['success'])) {
            echo '<div class="alert alert-dismissible alert-success">
      <strong>Realizado!</strong> la oferta se ha borrado correctamente.
    </div>';
        }
        ?>

        <div class="row container">
            <div class="pull-right">
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger active" href="?view=configofertas">GESTIONAR OFERTAS</a>
                        </li></ul></div>
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=configofertas&mode=add">CREAR OFERTA</a>
                        </li></ul></div>
                <div class="mbr-navbar__column"><ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active"><li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=categorias">GESTIONAR CATEGORÍAS</a>
                        </li></ul></div>
            </div>

            <ol class="breadcrumb">
                <li><a href="?view=index"><i class="fa fa-comments"></i> Ofertas</a></li>
            </ol>
        </div>

        <div class="row categorias_con_foros">
            <div class="col-sm-12">
                <div class="row titulo_categoria">Gestión de Ofertas</div>

                <div class="row cajas">
                    <div class="col-md-12">
                        <?php
                        if(false != $_ofertas) {
                            $HTML = '<table class="table"><thead><tr>
           <th style="width: 10%">Id</th>
           <th>Oferta</th>
           <th>Mensajes</th>
           <th>Temas</th>
           <th>Categoría</th>
           <th>Estado</th>
           <th style="width: 20%">Acciones</th>
           </tr></thead>
           <tbody>';
                            foreach($_ofertas as $id_oferta => $content_array) {
                                $estado = $_ofertas[$id_oferta]['estado'] == 1 ? 'Abierto' : 'Cerrado';
                                $HTML .= '<tr>
                  <td>'.$_ofertas[$id_oferta]['id'].'</td>
                  <td>'.$_ofertas[$id_oferta]['nombre'].'</td>
                  <td>'.$_ofertas[$id_oferta]['cantidad_ofertas'].'</td>
                  <td>'.$_ofertas[$id_oferta]['cantidad_temas'].'</td>
                  <td>'.$_categorias[$_ofertas[$id_oferta]['id_categoria']]['nombre'].'</td>
                  <td>'. $estado .'</td>
                  <td>
                    <div class="btn-group">
                     <a href="#" class="btn btn-primary">Acciones</a>
                     <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                     <ul class="dropdown-menu">
                       <li><a href="?view=configofertas&mode=edit&id='.$_ofertas[$id_oferta]['id'].'">Editar</a></li>
                       <li><a onclick="DeleteItem(\'¿Está seguro de eliminar esta categoría?\',\'?view=configofertas&mode=delete&id='.$_ofertas[$id_oferta]['id'].'\')">Eliminar</a></li>
                     </ul>
                   </div>
                  </td>
                </tr>';
                            }
                            $HTML .= '</tbody></table>';
                        } else {
                            $HTML = '<div class="alert alert-dismissible alert-info"><strong>INFORMACIÓN: </strong> Todavía no existe ningúna oferta.</div>';
                        }
                        echo $HTML;
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include(HTML_DIR . 'overall/footer.php'); ?>

</body>
</html>