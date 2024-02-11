<?php

class PasajesModel {
    //Obtain an instance of the BD
    private $bd;
    private $pdo;

    public function __construct() {
       // $this->pdo = new PDO('mysql:host=localhost;dbname=ejemplo10_tema6', 'root', '');
      $this->bd = new DB();
      $this->pdo = $this->bd->getPDO();
    }

    // Insert a pasaje into the bd
    public function guardarPasaje($pasajerocod, $identificador, $numasiento, $clase, $pvp){
        try {
            
            $sql = "INSERT INTO pasaje (pasajerocod, identificador, numasiento, clase, pvp) VALUES (?, ?, ?, ?, ?)";
            $sentencia = $this->pdo->prepare($sql);
            
            $sentencia->bindParam(1, $pasajerocod);
            $sentencia->bindParam(2, $identificador);
            $sentencia->bindParam(3, $numasiento);
            $sentencia->bindParam(4, $clase);
            $sentencia->bindParam(5, $pvp);
            
            if(!$sentencia->execute()){
                return "Error al grabar execute.". $e->getMessage();
            }
            
            return "Registro insertado correctamente."; 
            
        } catch (PDOException $e) {
                
            //Check if the variable contains already that id's
            if(str_contains($e->getMessage(), "Integrity constraint violation: 1062") ){
                return "Ese pasaje ya está creado.";
            }
            
            //If not exists then it means that it was another error
            //return "Error al grabar catch.<br>". $e->getMessage()." con coCODIGO ".$e->getCode();
            return "Error al grabar, vuelve a intentarlo.";
        }
    } 
    
    public function eliminarPasaje($id) {
        
        //Prepare for deleting the pasaje
        $sql = $this->pdo->prepare("DELETE FROM pasaje WHERE `pasaje`.`idpasaje` = ? ");
        
        $sql->bindParam(1, $id);
        
        if(!$sql->execute()){
            return "Error al eliminar el pasaje, vuelve a intentarlo.";
        }
        
        return "Pasaje ".$id." eliminado correctamente.";
    }
}