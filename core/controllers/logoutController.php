<?php
    //Con esta funcion nos salimos de la web
    unset($_SESSION['app_id']);
    header('location: ?view=index');