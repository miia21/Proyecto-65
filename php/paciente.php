<?php
    require_once ('autoload.php');

    class Paciente extends conexion{
        private $intRelaU;
        private $intRelaG;
        private $intRelaNI;
        private $intRelaD;
        private $intRelaGC;
        private $strNom;
        private $strApe;
        private $intDni;
        private $fechaFechaNac;
        private $strCel;
        private $strNomContacto;
        private $strApeContacto;
        private $strCelContacto;
        private $strEstUsr;
        private $conexion;

        public function __construct(){
            $this->conexion = new conexion();
            $this->conexion = $this->conexion->connect();
        }

        public function insertPaciente(int $relaUsers, int $relaGenero, int $relaNivel, int $relaDepa, int $relaGrupoC, string $nombre, string $apellido, int $dni, int $fechaNac, string $cel, string $nomContacto, string $apeContacto, string $celContacto, string $estUsr){
            $this->intRelaU = $relaUsers;
            $this->intRelaG = $relaGenero;
            $this->intRelaNI = $relaNivel;
            $this->intRelaD = $relaDepa;
            $this->intRelaGC = $relaGrupoC;
            $this->strNom = $nombre;
            $this->strApe = $apellido;
            $this->intDni = $dni;
            $this->fechaFechaNac = $fechaNac;
            $this->strCel = $cel;
            $this->strNomContacto = $nomContacto;
            $this->strApeContacto = $apeContacto;
            $this->strCelContacto = $celContacto;
            $this->strEstUsr = $estUsr;

            $sql = "INSERT INTO pacientes (rela_users, rela_genero, rela_nivel_instruccion, rela_departamento, rela_grupo_conviviente, nombre, apellido, dni, fecha_nacimiento, celular, nombre_contacto, apellido_contacto, celular_contacto, estado_users) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sql);
            $arrData = array($this->intRelaU, $this->intRelaG, $this->intRelaNI, $this->intRelaD, $this->intRelaGC, $this->strNom, $this->strApe, $this->intDni, $this->intFechaNac, $this->strCel, $this->strNomContacto, $this->strApeContacto, $this->strCelContacto, $this->strEstUsr);
            $resInsert = $insert->execute($arrData);
            $idInsert = $this->conexion->lastInsertId();
            return $idInsert;
        }

        public function getPaciente(int $id){
            $sql = "SELECT a.nombre, a.apellido, a.fecha_nacimiento, a.celular, b.nombre as genero, d.nombre_departamento  FROM pacientes a INNER JOIN generos b ON a.rela_genero = b.id INNER JOIN departamentos d ON a.rela_departamento = d.id WHERE a.id = $id";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetch(PDO::FETCH_ASSOC);
            return $request;
        }

        public function updatePaciente(int $id, int $relaUsers, int $relaGenero, int $relaNivel, int $relaDepa, int $relaGrupoC, string $nombre, string $apellido, int $dni, int $fechaNac, string $cel, string $nomContacto, string $apeContacto, string $celContacto, string $estUsr){
            $this->intRelaU = $relaUsers;
            $this->intRelaG = $relaGenero;
            $this->intRelaNI = $relaNivel;
            $this->intRelaD = $relaDepa;
            $this->intRelaGC = $relaGrupoC;
            $this->strNom = $nombre;
            $this->strApe = $apellido;
            $this->intDni = $dni;
            $this->intFechaNac = $fechaNac;
            $this->strCel = $cel;
            $this->strNomContacto = $nomContacto;
            $this->strApeContacto = $apeContacto;
            $this->strCelContacto = $celContacto;
            $this->strEstUsr = $estUsr;
            
            $sql = "UPDATE pacientes SET rela_users=?, rela_genero=?, rela_nivel_instruccion=?, rela_departamento=?, rela_grupo_conviviente=?, nombre=?, apellido=?, dni=?, fecha_nacimiento=?, celular=?, nombre_contacto=?, apellido_contacto=?, celular_contacto=?, estado_users=?  WHERE id = $id";
            $update = $this->conexion->prepare($sql);
            $arrData = array($this->intRelaU, $this->intRelaG, $this->intRelaNI, $this->intRelaD, $this->intRelaGC, $this->strNom, $this->strApe, $this->intDni, $this->intFechaNac, $this->strCel, $this->strNomContacto, $this->strApeContacto, $this->strCelContacto, $this->strEstUsr);
            $resExecute = $update->execute($arrData);
            return $resExecute;
        }

        public function getMedicamentosPorPaciente(int $id, $fecha_inicio = null, $fecha_fin = null) {
            $sql = "SELECT 
                        a.laboratorio_titular, 
                        a.nombre_comercial, 
                        b.dosis, 
                        b.frecuencia, 
                        b.fecha_alta 
                    FROM medicamentos a 
                    INNER JOIN medicamentos_pacientes b ON a.id_medicamento = b.rela_medicamento 
                    WHERE b.rela_paciente = ?";
        
            if ($fecha_inicio && $fecha_fin) {
                $sql .= " AND b.fecha_alta BETWEEN ? AND ?";
            }
            
            $arrWhere = array($id); 
        
            if ($fecha_inicio && $fecha_fin) {
                $arrWhere[] = $fecha_inicio;
                $arrWhere[] = $fecha_fin;
            }
        
            $query = $this->conexion->prepare($sql);
            $query->execute($arrWhere);
            $request = $query->fetchAll(PDO::FETCH_ASSOC);
            return $request;
        }
        
    }

?>