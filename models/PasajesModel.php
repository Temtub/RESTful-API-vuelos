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
                return "Error al grabar.". $e->getMessage();
            }
            
            return "Registro insertado correctamente."; 
            
        } catch (PDOException $e) {
            return "Error al grabar.<br>". $e->getMessage();
        }
    } 
}