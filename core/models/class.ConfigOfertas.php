<?php
class ConfigOfertas {
    private $id;
    private $db;
    private $nombre;
    private $descripcion;
    private $categoria;
    private $estado;
    public function __construct() {
        $this->db = new Conexion();
    }
    private function Errors($url,$add_mode = false) {
        global $_categorias;
        try {
            if(empty($_POST['nombre']) or empty($_POST['descripcion']) or !isset($_POST['estado'])) {
                throw new Exception(1);
            } else {
                $this->nombre = $this->db->real_escape_string($_POST['nombre']);
                $this->descripcion = $this->db->real_escape_string($_POST['descripcion']);
                $this->descrip = str_replace(
                    array('<script>','</script>','<script src','<script type='),'',$this->descrip);
                if($_POST['estado'] == 1) {
                    $this->estado = 1;
                } else {
                    $this->estado = 0;
                }
            }
            if(!array_key_exists($_POST['categoria'],$_categorias)) {
                throw new Exception(2);
            } else {
                $this->categoria = intval($_POST['categoria']);
            }
        } catch(Exception $error) {
            header('location: ' . $url . $error->getMessage());
            exit;
        }
    }
    public function Add() {
        $this->Errors('?view=configofertas&mode=add&error=',true);
        $this->db->query("INSERT INTO ofertas (nombre,descripcion,id_categoria,estado)
    VALUES ('$this->nombre','$this->descripcion','$this->categoria','$this->estado');");
        header('location: ?view=configofertas&mode=add&success=true');
    }
    public function Edit() {
        $this->id = intval($_GET['id']);
        $this->Errors('?view=configofertas&mode=edit&id='.$this->id.'&error=');
        $this->db->query("UPDATE ofertas SET nombre='$this->nombre', descripcion='$this->descripcion',
        id_categoria='$this->categoria', estado='$this->estado' WHERE id='$this->id';");
        header('location: ?view=configofertas&mode=edit&id='.$this->id.'&success=true');
    }
    public function Delete() {
        $this->id = intval($_GET['id']);
        $this->db->query("DELETE FROM ofertas WHERE id='$this->id';");
        header('location: ?view=configofertas&success=true');
    }
    public function __destruct() {
        $this->db->close();
    }
}
?>