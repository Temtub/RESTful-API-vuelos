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

//Methods for GET
if( $_SERVER['REQUEST_METHOD'] === 'DELETE'){

    if(isset($_GET['id']) ){
        
        try {
            
            $res = $reservas->eliminarPasaje(filter_input(INPUT_GET, "id") );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
    
    //Put the result in an array
    $resul['resultado'] = $res;
    
    //Show the array with the result as a json
    echo json_encode($resul);
    //Exit
    exit();
}

if( $_SERVER['REQUEST_METHOD'] === 'PUT'){
    
    $putData = json_decode(file_get_contents('php://input'), true);
    
    
    
    (!isset($putData['idpasaje'])|| !isset($putData['pasajerocod'])|| !isset($putData['identificador'])|| !isset($putData['numasiento'])|| !isset($putData['clase']) || !isset($putData['pvp']) ) ?
    ($res = "Recuerda, para actualizar as de rellenar todos los datos." ) :
    ($res = $reservas->actualizarPasaje($putData) );
    
    //Put the result in an array
    $resul['resultado'] = $res;
    
    //Show the array with the result as a json
    echo json_encode($resul);
    //Exit
    exit();
}

