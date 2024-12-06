<?php
    class conexion{
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $database = "proyecto_65";
        private $conect;

        public function __construct(){
            $connectionString = "mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8";
            try{
                $this->conect = new PDO($connectionString, $this->user, $this->password);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                $this->conect = 'Error al conectar a la base de datos';
                echo "ERROR: ". $e->getMessage();
            }
        }

        public function connect(){
            return $this->conect;
        }
    }
?>