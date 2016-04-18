<?php
function Ofertas() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM ofertas;");
    if($db->rows($sql) > 0) {
        while($d = $db->recorrer($sql)) {
            $ofertas[$d['id']] = array(
                'id' => $d['id'],
                'nombre' => $d['nombre'],
                'descripcion' => $d['descripcion'],
                'cantidad_ofertas' => $d['cantidad_ofertas'],
                'cantidad_temas' => $d['cantidad_temas'],
                'id_categoria' => $d['id_categoria'],
                'estado' => $d['estado']
            );
        }
    } else {
        $ofertas = false;
    }
    $db->liberar($sql);
    $db->close();
    return $ofertas;
}
?>