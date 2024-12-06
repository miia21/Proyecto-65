<?php
    require_once ('autoload.php');

    class Medicamento extends conexion{
        private $strLab;
        private $strNom;
        private $conexion;

        public function __construct(){
            $this->conexion = new conexion();
            $this->conexion = $this->conexion->connect();
        }

        public function insertMedicamento(string $laboratorio, string $nombre){
            $this->strLab = $laboratorio;
            $this->strNom = $nombre;

            $sql = "INSERT INTO medicamentos (laboratorio_titular, nombre_comercial) VALUES (?, ?)";
            $insert = $this->conexion->prepare($sql);
            $arrData = array($this->strLab, $this->strNom);
            $resInsert = $insert->execute($arrData);
            $idInsert = $this->conexion->lastInsertId();
            return $idInsert;
        }

        public function getMedicamentos(){
            $sql = "SELECT laboratorio_titular, nombre_comercial FROM medicamentos";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        public function updateMedicamento(int $id, string $laboratorio, string $nombre){
            $this->strLab = $laboratorio;
            $this->strNom = $nombre;

            $sql = "UPDATE medicamentos SET laboratorio_titular=?, nombre_comercial=? WHERE id=?";
            $update = $this->conexion->prepare($sql);
            $arrData = array($this->strLab, $this->strNom, $id);
            $resExecute = $update->execute($arrData);
            return $resExecute;
        }

        public function fechaMedicamento(string $fecha_inicio, string $fecha_fin){
            $sql = "SELECT laboratorio_titular, nombre_comercial FROM medicamentos WHERE fecha_inicio = $fecha_inicio AND fecha_fin = $fecha_fin";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }
    }

?>