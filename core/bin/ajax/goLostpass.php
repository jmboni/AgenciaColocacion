<?php

//Instanciamos conexión base de datos
$db = new Conexion();

//Recogemos la variable email
$email=$db->real_escape_string($_POST['email']);

//creamos la sentencia para comprobar que en la base de datos hay un mail como el indicado
$sql =$db->query("SELECT id,user FROM users WHERE email='$email' LIMIT 1;");

if($db->rows($sql)>0){
    //Recorremos el array sabiendo que solo hay un registro.
    $data = $db->recorrer($sql);
    $id=$data[0];
    $user=$data[1];

    //Generamos las claves nuevas para enviar por correo.
    $keypass = md5(time());

    //Utilizamos sha para generar menos caracteres
    $new_pass = strtoupper(substr(sha1(time()),0,8));

    //Generamos una variable link para enviar por correo.
    $link=APP_URL . '?view=lostpass&key='. $keypass;

    //Utilizamos PHPMailer para enviar mail de activacion antes del registro.
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "quoted-printable";
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = PHPMAILER_HOST;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = PHPMAILER_USER;                 // SMTP username
    $mail->Password = PHPMAILER_PASS;                           // SMTP password
    $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
    /*$mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );*/
    $mail->Port = PHPMAILER_PORT;                                    // TCP port to connect to
    $mail->setFrom(PHPMAILER_USER, APP_TITLE); //Quien manda el correo?
    $mail->addAddress($email, $user);     // A quien le llega
    $mail->isHTML(true);    // Set email format to HTML

    $mail->Subject = 'Recuperación de contraseña';

    //LLamamos a la función para generar el HTML del mail
    $mail->Body    = LostpassTemplate($user,$link);
    $mail->AltBody = 'Hola '.$user.' para recuperar tu contraseña, pincha sobre este enlace: '.$link;

    //Si el mail no se envia mandamos mensaje de error
    if(!$mail->send()) {
        $HTML = '<div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>ERROR:</strong>'.$mail->ErrorInfo.' </div>';
    //En el caso que el mail se envia modificamos los datos en la base de datos
    } else {
        $db->query("UPDATE users SET keypass='$keypass', new_pass='$new_pass' WHERE id='$id';");
        $HTML = 1;
    }
}else{
    $HTML = '<div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <h4>ERROR:</h4><p> El email solicitado no existe en el sistema.</p></div>';
}
//Liberamos la consulta
$db->liberar($sql);

//Cerramos la conexión.
$db->close();

echo $HTML;

