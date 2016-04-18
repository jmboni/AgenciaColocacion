<?php

//Comprobamos que por la URL viene una Key de activación y que el usuario está logueado
if(isset($_GET['key'],$_SESSION['app_id'])){
    //Instanciamos una nueva conexión
    $db = new Conexion();

    //Cogemos el id del usuario actual.
    $id=$_SESSION['app_id'];

    //Recogemos la variable Key que viene por la url como GET
    $key = $db->real_escape_string($_GET['key']);

    //Creamos la consult SQL
    //Selecionamos de la tabla ususarios a que el id sea el de la sesion y la keyreg coincida
    $sql = $db->query("SELECT id FROM users WHERE id='$id' AND keyreg='$key' LIMIT 1;");

    //Comprobamos si la consulta nos da resultado.
    if($db->rows($sql)>0){
        //Actualizamos los datos del usuario activando la cuencta
        $db->query("UPDATE users SET activo='1', keyreg='' WHERE id='$id';");

        header('location: ?view=index&success=true');
    }else{
        header('location: ?view=index&error=true');
    }
    //Liberamos la consulta
    $db->liberar($sql);
    //Cerramos la conexión
    $db->close();
}else{
    //Si no es así volvemos a la página de inicio
    include(HTML_DIR.'public/loguearte.php');
}