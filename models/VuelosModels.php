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
        vuelo.fechavuelo,
        aero1.nombre AS nombreaeropuertoorigen, 
        aero1.pais AS paisorigen, 
        aero2.nombre AS nombreaeropuertodestino, 
        aero2.pais AS paisdestino,
        COUNT(pasaje.identificador) AS numeropasajeros
        FROM aeropuerto aero1 
        RIGHT JOIN vuelo ON vuelo.aeropuertoorigen = aero1.codaeropuerto 
        RIGHT JOIN aeropuerto aero2 ON aero2.codaeropuerto = vuelo.aeropuertodestino 
        LEFT JOIN pasaje ON pasaje.identificador = vuelo.identificador
        WHERE vuelo.identificador = ?');
        
        //Say that want to bring an indexed array by name
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        //If theres an error in this part it throws an exception
        if(!$stmt->execute()){
            throw new PDOException("Error consiguiendo vuelos");
        }
        
        //Return all the vuelos as a json
        return json_encode($stmt->fetchAll() );
    }  
    
    //Con los datos de la consulta de arriba
//    public function getOneVuelo($id){
//        $stmt = $this->pdo->prepare('SELECT 
//        vuelo.identificador, 
//        vuelo.aeropuertoorigen, 
//        vuelo.aeropuertodestino, 
//        vuelo.tipovuelo, 
//        aero1.nombre AS aeropuertoorigen, 
//        aero1.pais AS paisorigen, 
//        aero2.nombre AS aeropuertodestino, 
//        aero2.pais AS paisdestino,
//        COUNT(pasaje.identificador) AS numeropasajeros
//        FROM aeropuerto aero1 
//        RIGHT JOIN vuelo ON vuelo.aeropuertoorigen = aero1.codaeropuerto 
//        RIGHT JOIN aeropuerto aero2 ON aero2.codaeropuerto = vuelo.aeropuertodestino 
//        LEFT JOIN pasaje ON pasaje.identificador = vuelo.identificador
//        WHERE vuelo.identificador = ?
//        GROUP BY vuelo.identificador;');
//        
//        $stmt->bindParam(1, $id);
//        $finish = $stmt->execute();
//
//        if ($finish) {
//            // La consulta se ejecutó correctamente, ahora recuperamos los resultados
//            $result = $stmt->fetch(PDO::FETCH_ASSOC);
//            return $result;
//        } else {
//            // La consulta falló
//            return "Ha ocurrido un problema consiguiendo su hotel.";
//        }
//   }
    
    //Con los datos normales de la bd
    public function getOneVuelo($id){
        $stmt = $this->pdo->prepare('SELECT * FROM vuelo WHERE identificador=?');
        
        $stmt->bindParam(1, $id);
        $finish = $stmt->execute();

        if ($finish) {
            // La consulta se ejecutó correctamente, ahora recuperamos los resultados
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            // La consulta falló
            return "Ha ocurrido un problema consiguiendo su hotel.";
        }

    }
}