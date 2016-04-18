<?php

    //Instanciamos una nueva conexión a la base de datos
    $db = new Conexion();

    //Recogemos las variables enviadas por POST

    $user = $db->real_escape_string($_POST['user']);

    //Codificamos la contraseña
    $pass = Encrypt($_POST['pass']);

    $email = $db->real_escape_string($_POST['email']);


    //Comprobamos si existe algun usuario registrado conn los mismos datos en la base de datos.
    //Limitamos la busqueda a uno ya que en cuanto encontremos uno nos salimos, evitamos buscar más.
    $sql = $db->query("SELECT user FROM users WHERE user='$user' OR email='$email' LIMIT 1;");

    //Si no hay ningun usuario ni email podemos registrar usuario
    if($db->rows($sql) == 0) {

        //Obtenemos una clave única para el link de activación de registro
        $keyreg = md5(time());

        //Variable con el enlace a pinchar para activar la cuenta dada de alta.
        $link = APP_URL . '?view=activar&key=' . $keyreg; //URL enviada por mail para la activación.

        //Utilizamos PHPMailer para enviar mail de activacion antes del registro.
        $mail = new PHPMailer;

        //Definimos el idioma de PHPMailer
        $mail->setLanguage('es', APP_URL.'/vendor/phpmailer/language/directory/phpmailer.lang-es.php');

        $mail->CharSet = "UTF-8";
        $mail->Encoding = "quoted-printable";

        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host = PHPMAILER_HOST;                           // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
        $mail->Username = PHPMAILER_USER;                       // SMTP username
        $mail->Password = PHPMAILER_PASS;                       // SMTP password
        $mail->SMTPSecure = 'TLS';                              // Enable TLS encryption, `ssl` also accepted
        /*$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );*/
        $mail->Port = PHPMAILER_PORT;                           // TCP port to connect to

        $mail->setFrom(PHPMAILER_USER, APP_TITLE);          // Quien manda meial
        $mail->addAddress($email, $user);                   // A quien se le manda mail
        $mail->isHTML(true);                                // Si enviamos mail como HTML

        $mail->Subject = 'Activación de tu cuenta';
        $mail->Body    = EmailTemplate($user,$link);
        $mail->AltBody = 'Hola '.$user.' para activar tu cuenta, pincha sobre este enlace: '.$link;

        if(!$mail->send()) {
            $HTML = '<div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>ERROR:</strong>'.$mail->ErrorInfo.' </div>';
        } else {
            //Si ha ido bien y el email se ha podido enviar, registramos al usuario en la base de datos
            //El permiso del usuario por defecto sera 0.
            $db->query("INSERT INTO users (user,pass,email,keyreg) VALUES ('$user','$pass','$email','$keyreg');");

            //Creamos una variable de sesion y recogemos el id del usuario
            //Primero creamos una Sql para recoger los datos del último usuario registrado.
            $sql2=$db->query("SELECT MAX(id) AS id FROM users;");
            //Como solo tenemos un usuario en el array cogemos el 0.
            $_SESSION['app_id']= $db->recorrer($sql2)[0];
            $db->liberar($sql2);
            $HTML=1;
        }
    //Si si existe algun usuario con dichos datos damos error.
    }else{
        //Comprobamos si lo que se repite es usuario o mail
        $usuario=$db->recorrer($sql[0]);
        if(strlower($user)== strlower($usuario)){
            $HTML = '<div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>ERROR:</strong> El usuario ya existe en la base de datos
              </div>';
        }else{
            $HTML = '<div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>ERROR:</strong> El email ya existe en la base de datos
              </div>';
        }
    }

    //Liberamos la consulta realizada a la base de datos
    $db->close();//Cerramos la conexión con la base de datos

    //Escribimos el mensaje por pantalla
    echo $HTML;