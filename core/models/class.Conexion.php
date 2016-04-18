<?php
  class Conexion extends mysqli {


    public function __construct(){
      parent::__construct(DB_HOST,DB_USER,DB_PASS,DB_NAME);

      //Verificamos si hay algún error en la conexión con la base de datos
      $this->connect_errno ? die('Error en la conexión con la base de datos'): null;
      $this->set_charset("utf8");
    }

    //Creamos los metodos para la base de datos

    public function rows($query){
      return mysqli_num_rows($query);
    }

    public function liberar($query){
      return mysqli_free_result($query);
    }

    public function recorrer($query){
      return mysqli_fetch_array($query);
    }


  }//Fin clase
