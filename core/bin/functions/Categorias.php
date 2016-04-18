<?php
function Categorias() {
    $db = new Conexion();
    $sql = $db->query("SELECT * FROM categorias ORDER BY nombre;");
    if($db->rows($sql) > 0) {
        while($data = $db->recorrer($sql)) {
            $categorias[$data['id']] = array(
                'id' => $data['id'],
                'nombre' => $data['nombre']
            );
        }
    } else {
        $categorias = false;
    }
    $db->liberar($sql);
    $db->close();
    return $categorias;
}
?>