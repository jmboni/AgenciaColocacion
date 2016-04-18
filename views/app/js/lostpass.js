function goLostpass() {
    var connect, form, response, result, email;
    email = __('email_lostpass').value;

        //Comporbamos que no esta vacio el campo email
    if(email !=''){
        //Variables que pasamos por POST
        form = 'email=' + email;

        connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        connect.onreadystatechange = function() {
            if(connect.readyState == 4 && connect.status == 200) {
                if(connect.responseText == 1) {
                    result = '<div class="alert alert-dismissible alert-success">';
                    result += '<h4>Se ha enviado un correo </h4>';
                    result += '<p><strong>Revisa tu bandeja de entrada, si no lo ves revisa la carpeta de spam</strong></p>';
                    result += '</div>';
                    __('_AJAX_LOSTPASS_').innerHTML = result;
                    location.reload();
                } else {
                    __('_AJAX_LOSTPASS_').innerHTML = connect.responseText;
                }
            } else if(connect.readyState != 4) {
                result = '<div class="alert alert-dismissible alert-warning">';
                result += '<button type="button" class="close" data-dismiss="alert">x</button>';
                result += '<h4>Procesando...</h4>';
                result += '<p><strong>Estamos modificando tu contraseña....</strong></p>';
                result += '</div>';
                __('_AJAX_LOSTPASS_').innerHTML = result;
            }
        }
        connect.open('POST','ajax.php?mode=lostpass',true);
        connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        connect.send(form);
    }else{
        //Si email esta vacio
        result = '<div class="alert alert-dismissible alert-danger">';
        result += '<button type="button" class="close" data-dismiss="alert">x</button>';
        result += '<h4>Error</h4>';
        result += '<p><strong>Debes facilitar un email</strong></p>';
        result += '</div>';
        __('_AJAX_LOSTPASS_').innerHTML = result;
    }

}//Fin función

function runScriptLostpass(e) {
    if(e.keyCode == 13) {
        goLostpass();
    }
}
