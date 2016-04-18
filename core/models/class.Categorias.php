<?php

    class Categorias{

        private $db;
        private $id;
        private $nombre;

        /**
         * Categorias constructor.
         */
        public function __construct()
        {
            $this->db=new Conexion();
        }

        /**
         * @param $url
         */
        private function Errors($url){
            try{
                if (empty($_POST['nombre'])){
                    throw new Exception(1);
                }else{
                    $this->nombre=$this->db->real_escape_string($_POST['nombre']);
                }
            }catch(Exception $error){
                header('location:'.$url .$error->getMessage());
                exit;
            }
        }


        public function Add()
        {
            $this->Errors('?view=categorias&mode=add&error=');
            $this->db->query("INSERT INTO categorias (nombre) VALUES ('$this->nombre');");
            header('location: ?view=categorias&mode=add&success=true');
        }


        public function Edit()
        {
            $this->id=intval($_GET['id']);
            $this->Errors('?view=categorias&mode=edit&id='.$this->id.'&error=');
            $this->db->query("UPDATE categorias SET nombre='$this->nombre' WHERE id='$this->id';");
            header('location: ?view=categorias&mode=edit&id='.$this->id.'&success=true');
        }

        public function Delete() {
            $this->id = intval($_GET['id']);
            $q = "DELETE FROM categorias WHERE id='$this->id';";
            $q .= "DELETE FROM ofertas WHERE id_categoria='$this->id';";
            $this->db->multi_query($q);
            header('location: ?view=categorias');
        }

        /**
         *
         */
        public function __destruct()
        {
            $this->db->close();
        }
    }