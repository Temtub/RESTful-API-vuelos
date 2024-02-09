<?php

class VuelosModels {
    //Obtain an instance of the BD
    private $bd;
    private $pdo;

    public function __construct() {
       // $this->pdo = new PDO('mysql:host=localhost;dbname=ejemplo10_tema6', 'root', '');
      $this->bd = new DB();
      $this->pdo = $this->bd->getPDO();
    }

    // Get all the vuelos from the bd
    public function getAllVuelos() {
        // Preparamos una consulta de PDO para recuperar todas las tareas de la tabla "habitaciones" y lo reservamos en una nueva variable
        $stmt = $this->pdo->prepare('SELECT 
        vuelo.identificador, 
        vuelo.aeropuertoorigen, 
        vuelo.aeropuertodestino, 
        vuelo.tipovuelo, 
        aero1.nombre AS aeropuertoorigen, 
        aero1.pais AS paisorigen, 
        aero2.nombre AS aeropuertodestino, 
        aero2.pais AS paisdestino,
        COUNT(pasaje.identificador) AS numeropasajeros
        FROM aeropuerto aero1 RIGHT JOIN vuelo ON vuelo.aeropuertoorigen  = aero1.codaeropuerto RIGHT JOIN aeropuerto aero2 ON aero2.codaeropuerto = vuelo.aeropuertodestino LEFT JOIN pasaje ON pasaje.identificador = vuelo.identificador
        GROUP BY vuelo.identificador');
        
        //Say that want to bring an indexed array by name
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        //If theres an error in this part it throws an exception
        if(!$stmt->execute()){
            throw new PDOException("Error consiguiendo vuelos");
        }
        
        //Return all the vuelos as a json
        return json_encode($stmt->fetchAll() );
    }   
}