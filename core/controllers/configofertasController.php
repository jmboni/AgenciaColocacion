<?php
if(isset($_SESSION['app_id']) and $_users[$_SESSION['app_id']]['permisos'] >= 2) {
    $isset_id = isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] >= 1;
    require('core/models/class.ConfigOfertas.php');
    $config_ofertas = new ConfigOfertas();
    switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
        case 'add':
            if($_POST) {
                $config_ofertas->Add();
            } else {
                include(HTML_DIR . 'ofertas/add_ofertas.php');
            }
            break;
        case 'edit':
            if($isset_id and array_key_exists($_GET['id'],$_ofertas)) {
                if($_POST) {
                    $config_ofertas->Edit();
                } else {
                    include(HTML_DIR . 'ofertas/edit_ofertas.php');
                }
            } else {
                header('location: ?view=configofertas');
            }
            break;
        case 'delete':
            if($isset_id) {
                $config_ofertas->Delete();
            } else {
                header('location: ?view=configofertas');
            }
            break;
        default:
            include(HTML_DIR . 'ofertas/all_ofertas.php');
            break;
    }
} else {
    header('location: ?view=index');
}
?>