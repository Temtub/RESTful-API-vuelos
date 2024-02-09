<?php

// Get the bd file and the model from the bd
require_once ('./bd/DB.php');
require_once ('./models/PasajesModel.php');

$reservas = new PasajesModel();

// Tell that in the header that the content we will send is a json
@header("Content-type: application/json");

//Method for including a pasaje
if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $postData = json_decode(file_get_contents('php://input'), true);
    
    $res = $reservas->guardarPasaje($postData['pasajerocod'], $postData['identificador'], $postData['numasiento'], $postData['clase'], $postData['pvp'] );
    
    $resul['resultado'] = $res;
    
    echo json_encode($resul);
    exit();
}