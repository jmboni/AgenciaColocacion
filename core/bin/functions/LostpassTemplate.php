<?php
function LostpassTemplate($user,$link) {
    $HTML = '
  <html>
  <body style="background: #FFFFFF;font-family: Verdana; font-size: 14px;color:#1c1b1b;">
  <div style="">
      <h2>Hola '.$user.'</h2>
      <p style="font-size:17px;">Hemos recibido una solicitud de cambio de contraseña</p>
  	<p>El día '.date('d/m/Y', time()).' se ha generado una solicitud de recuperación de contraseña <br/>Si no ha sido así no hgas caso a este mensaje </p>
  	<p style="padding:15px;background-color:#ECF8FF;">
  			Para cambiar tu contraseña por favor haz <a style="font-weight:bold;color: #2BA6CB;" href="'.$link.'" target="_blank">clic aquí &raquo;</a>
  	</p>
      <p style="font-size: 9px;">&copy; '. date('Y',time()) .' '.APP_TITLE.'. Todos los derechos reservados.</p>
  </div>
  </body>
  </html>
  ';
    return $HTML;
}