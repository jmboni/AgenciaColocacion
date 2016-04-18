<?php
    if(isset($_SESSION['app_id']) and $_users[$_SESSION['app_id']]['permisos'] >= 2) {

        //Con esta variable sabemos el elemento seleccionado para borrar o editar
        $isset_id=isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id']>1;

        require('core/models/class.Categorias.php');
        $categorias=new Categorias();

        switch(isset($_GET['mode'])? $_GET['mode']:null){
            case 'add':
                if($_POST){
                    $categorias->Add();
                }else{
                    include(HTML_DIR.'categorias/add_categoria.php');
                }
                break;
            case 'edit':
                //Si tenemos un elemento para editar
                if($isset_id and array_key_exists($_GET['id'],$_categorias)) {
                    //Ahora comprobamos si hemos enviado datos de un formulario
                    if($_POST){
                        $categorias->Edit();
                    }else{   //Si no  hay datos mostramos formulario de edicion
                        include(HTML_DIR.'categorias/edit_categoria.php');
                    }
                }else{
                    header('location: ?view=categorias');
                }
                break;
            case 'delete':
                //Si tenemos un elemento para borrar
                if($isset_id){
                    $categorias->Delete();
                }else{
                    header('location: ?view=categorias');
                }
                break;
            default:
                //Si no esta definida la opcion es decir mode
                include(HTML_DIR.'categorias/all_categoria.php');
                break;
        }
    }else{
        header('location:?view=index');
    }
