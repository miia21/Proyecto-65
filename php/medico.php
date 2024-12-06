<?php
    require_once ('autoload.php');

    class Medico extends conexion{
        private $intRela;
        private $intMatricula;
        private $intDni;
        private $strNom;
        private $strApe;
        private $strEspecialidad;
        private $intTel;
        private $strDomi;
        private $conexion;

        public function __construct(){
            $this->conexion = new conexion();
            $this->conexion = $this->conexion->connect();
        }

        public function insertMedico(int $relacion, int $matricula, int $dni, string $nombre, string $apellido, string $especialidad, int $telefono, string $domicilio){
            $this->intRela = $relacion;
            $this->intMatricula = $matricula;
            $this->intDni = $dni;
            $this->strNom = $nombre;
            $this->strApe = $apellido;
            $this->strEspecialidad = $especialidad;
            $this->intTel = $telefono;
            $this->strDomi = $domicilio;

            $sql = "INSERT INTO medicos (rela_users, matricula, dni, nombre, apellido, especialidad, telefono, domicilio) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sql);
            $arrData = array($this->intRela, $this->intMatricula, $this->intDni, $this->strNom, $this->strApe, $this->strEspecialidad, $this->intTel, $this->strDomi);
            $resInsert = $insert->execute($arrData);
            $idInsert = $this->conexion->lastInsertId();
            return $idInsert;
        }

        public function getMedicos(){
            $sql = "SELECT id, matricula, nombre, apellido, especialidad FROM medicos";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        public function updateMedico(int $id, int $relacion, int $matricula, int $dni, string $nombre, string $apellido, string $especialidad, int $telefono, string $domicilio){
            $this->intReala = $relacion;
            $this->intMatricula = $matricula;
            $this->intDni = $dni;
            $this->strNom = $nombre;
            $this->strApe = $apellido;
            $this->strEspecialidad = $especialidad;
            $this->intTel = $telefono;
            $this->strDomi = $domicilio;

            $sql = "UPDATE medicos SET rela_users=?, matricula=?, dni=?, nombre=?, apellido=?, especialidad=?, telefono=?, domicilio=? WHERE id=?";
            $update = $this->conexion->prepare($sql);
            $arrData = array($this->intReala, $this->intMatricula, $this->intDni, $this->strNom, $this->strApe, $this->strEspecialidad, $this->intTel, $this->strDomi, $id);
            $resExecute = $update->execute($arrData);
            return $resExecute;
        }

        public function getPacientesPorMedico(int $id) {
            $sql = "SELECT 
                        a.id,
                        a.nombre, 
                        a.apellido
                    FROM pacientes a 
                    INNER JOIN medico_pacientes b ON a.id = b.rela_paciente 
                    WHERE b.rela_medico = ?";
            
            $arrWhere = array($id);
            $query = $this->conexion->prepare($sql);
            $query->execute($arrWhere);
            $request = $query->fetchAll(PDO::FETCH_ASSOC);
            return $request;
        }
    }
?>