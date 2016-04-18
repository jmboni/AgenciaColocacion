<?php


//Primero comprobamos si alguno de los datos esta vacio
//Ya que si es asi no seguimos con la conexión
if(!empty($_POST['user']) and !empty($_POST['pass'])){


    //Instanciamos a una nueva conexion a la base de datos.
    $db = new Conexion();

    //Cogemos datos que nos llegan de la base de datos
    $data = $db->real_escape_string($_POST['user']);
    $pass=Encrypt($_POST['pass']);

    //Comprobamos por usuario o email si existe el usuario
    $sql = $db->query("SELECT id FROM users WHERE (user='$data' OR email='$data') AND pass='$pass' LIMIT 1;");

    //Una vez lanzado la query comprobamos que hay resultado para ver si existe el usuario
    if ($db->rows($sql) > 0 )
    {
      //Declaramos una sesion de 1 dia si marcamos el check de recordar
      if ($_POST['check']){ini_set('session.cookie_lifetime',time()+(60*60*24));}
      //Creamos una variable de sesion con el id del usuario
      $_SESSION['app_id']=$db->recorrer($sql)[0];
      echo 1;
    } else {
      // Si no podemos acceder
      echo '<div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>ERROR:</strong> El usuario o contraseña no es valido.
            </div>';
    }
    //Liberamos la SQL
    $db->liberar($sql);
    //Cerramos la conecion con la base de datos.
    $db->close();
} else {
    // Si no hay datos de conexion en el formulario
    echo '<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>ERROR:</strong> No puede haber campos vacios.
          </div>';
} //Fin if
