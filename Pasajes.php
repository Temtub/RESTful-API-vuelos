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
   
    //ternary operator for checking if all the data has been bringed correctly or else create a message to say to the user
    (!isset($postData['pasajerocod'])|| !isset($postData['identificador'])|| !isset($postData['numasiento'])|| !isset($postData['clase'])|| !isset($postData['pvp']) ) ?
    ($res = "Recuerda rellenar todos los datos." ) :
    ($res = $reservas->guardarPasaje($postData['pasajerocod'], $postData['identificador'], $postData['numasiento'], $postData['clase'], $postData['pvp'] ) );
    
    //Put the result in an array
    $resul['resultado'] = $res;
    
    //Show the array with the result as a json
    echo json_encode($resul);
    //Exit
    exit();
}