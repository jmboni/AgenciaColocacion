<?php
  //Funcion de encriptado para la contraseña de los usuarios
  function Encrypt($string){
    //Obtenemos la longitud del String
    $long = strlen($string);

     $encripted ='';
    //Recorremos el string
    for($i=0; $i<$long ;$i++)
    {
      //Si es par encriptamos y si no lo es dejamos como esta.
       $encripted .= ( $i % 2) != 0 ? md5($string[$i]) : $i;
    }

    return md5($encripted);
  }
