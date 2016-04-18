<?php

    //En esta funcion tendremos toda la información de todos los usuarios.
    function Users()
    {
        $_users="";
        //Llamamos a una nueva instancia para conectarnos a la base de datos
        $db = new Conexion();

        //Creamos la consulta a la base de datos
        $sql = $db -> query("SELECT * FROM users");

        //Vemos si hay usuarios en el sistema.
        if($db->rows($sql)>0)
            //Si hay usuarios los recorremos todos y almacenamos el id de cada uno en un array
        {
            while ($d = $db -> recorrer($sql))
            {
                $_users[$d['id']]=array(
                    'id'=> $d['id'],
                    'user'=> $d['user'],
                    'pass'=> $d['pass'],
                    'email'=> $d['email'],
                    'permisos'=> $d['permisos']

                );
            }
        }


        //Liberamos la consula de la base de datos
        $db->liberar($sql);

        //Cerramos la conexión con la base de datos
        $db->close();

        //Devolvemos el array con los datos de los usuarios.
        return $_users;
    }