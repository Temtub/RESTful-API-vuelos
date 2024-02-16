<?php

// Get the bd file and the model from the bd
require_once ('./bd/DB.php');
require_once ('./models/PasajerosModel.php');

$pasajeros = new PasajerosModel();

// Tell that in the header that the content we will send is a json
@header("Content-type: application/json");

//Check if any data has been sent by get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //Get from the model of vuelos all the vuelos as a json
    try {
        $vuelosJson = $pasajeros->getAllPasajeros();
    } catch (Exception $ex) {
        echo "Error consiguiendo pasajeros, pruebe más tarde.";
        exit;
    }
    
    print_r($vuelosJson);
    
}//End of GET checking
