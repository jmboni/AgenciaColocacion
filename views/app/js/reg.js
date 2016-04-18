function goReg() {
    var connect, form, response, result, user, pass,email,pass_dos, tyc;
    user = __('user_reg').value;
    pass = __('pass_reg').value;
    email = __('email_reg').value;
    pass_dos = __('pass_reg_dos').value;
    tyc =__('tyc_reg').checked ? true : false;


    //Comprobamos si hemos aprobado los terminos y condiciones
    if(tyc == true){
        //Verificamos si todos los datos existen
        if(user != '' && pass !='' && pass_dos != '' && email != '' ){
            if(pass == pass_dos) {
                form = 'user=' + user + '&pass=' + pass + '&email=' + email;
                connect = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                connect.onreadystatechange = function() {
                    if(connect.readyState == 4 && connect.status == 200) {
                        if(connect.responseText == 1) {
                            result = '<div class="alert alert-dismissible alert-success">';
                            result += '<h4>Registro completado!</h4>';
                            result += '<p><strong>Estamos redireccionandote...</strong></p>';
                            result += '</div>';
                            __('_AJAX_REG_').innerHTML = result;
                            location.reload();
                        } else {
                            __('_AJAX_REG_').innerHTML = connect.responseText;
                        }
                    } else if(connect.readyState != 4) {
                        result = '<div class="alert alert-dismissible alert-warning">';
                        result += '<button type="button" class="close" data-dismiss="alert">x</button>';
                        result += '<h4>Procesando...</h4>';
                        result += '<p><strong>Estamos procesando tu registro.</strong></p>';
                        result += '</div>';
                        __('_AJAX_REG_').innerHTML = result;
                    }
                }
                connect.open('POST','ajax.php?mode=reg',true);
                connect.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                connect.send(form);
            }else{
                //Si las contraseñas no coinciden
                result = '<div class="alert alert-dismissible alert-danger">';
                result += '<button type="button" class="close" data-dismiss="alert">x</button>';
                result += '<h4>ERROR</h4>';
                result += '<p><strong>Las contraseñas no coinciden.</strong></p>';
                result += '</div>';
                __('_AJAX_REG_').innerHTML = result;
            }
        }else{
            //Si falta algún dato damos mensaje error.
            result = '<div class="alert alert-dismissible alert-danger">';
            result += '<button type="button" class="close" data-dismiss="alert">x</button>';
            result += '<h4>ERROR</h4>';
            result += '<p><strong>Todos los campos deben estar llenos.</strong></p>';
            result += '</div>';
            __('_AJAX_REG_').innerHTML = result;
        }
    }else{
        result = '<div class="alert alert-dismissible alert-danger">';
        result += '<button type="button" class="close" data-dismiss="alert">x</button>';
        result += '<h4>ERROR</h4>';
        result += '<p><strong>Los términos y condiciones deben ser aceptados</strong></p>';
        result += '</div>';
        __('_AJAX_REG_').innerHTML = result;
    }
}

function runScriptReg(e) {
    if(e.keyCode == 13) {
        goReg();
    }
}
