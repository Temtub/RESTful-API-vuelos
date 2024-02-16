<?php

class PasajerosModel {
    //Obtain an instance of the BD
    private $bd;
    private $pdo;

    public function __construct() {
       // $this->pdo = new PDO('mysql:host=localhost;dbname=ejemplo10_tema6', 'root', '');
      $this->bd = new DB();
      $this->pdo = $this->bd->getPDO();
    }

    // Get all the vuelos from the bd
    public function getAllPasajeros() {
        // Preparamos una consulta de PDO para recuperar todas las tareas de la tabla "habitaciones" y lo reservamos en una nueva variable
        $stmt = $this->pdo->prepare('SELECT * FROM pasajero');
        
        //Say that want to bring an indexed array by name
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        //If theres an error in this part it throws an exception
        if(!$stmt->execute()){
            throw new PDOException("Error consiguiendo pasajeros");
        }
        
        //Return all the vuelos as a json
        return json_encode($stmt->fetchAll() );
    }  
}