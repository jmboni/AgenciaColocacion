<?php

    //Primero controlamos que no hay definidad una sesion y que existe una variable key
    if(!isset($_SESSION['app_id']) and isset($_GET['key'])){
        //Instanciamos la conexión
        $db = new Conexion();

        //Recogemos la variabl keypass
        $keypass= $db->real_escape_string($_GET['key']);

        //Creamos el query
        $sql = $db->query("SELECT id, new_pass FROM users WHERE keypass='$keypass' LIMIT 1;");

        //Verificamos que hay registros con dicho keypass
        if($db->rows($sql)>0){
            $data=$db->recorrer($sql);

            $id_user=$data[0];
            $new_pass = Encrypt($data[1]);
            $password = $data[1];

            $db->query("UPDATE users SET keypass='', pass='$new_pass' WHERE id='$id_user';");

            //incluimos mensaje con link de recuperación
            include('html/lostpass_mensaje.php');
        }else{
            header('location: ?view=index');
        }
        //Liberamos la consulta
        $db ->liberar($sql);

        //Cerramos la conexión
        $db ->close();

    }else{
        header('location: ?view=index');
    }