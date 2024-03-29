<?php

// Get the bd file and the model from the bd
require_once ('./bd/DB.php');
require_once ('./models/VuelosModels.php');

$vuelos = new VuelosModels();

// Tell that in the header that the content we will send is a json
@header("Content-type: application/json");

//Check if any data has been sent by get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    //If isset the id of the vuelo, then gets only a fly
    if (isset($_GET['id']) ){
        //Get the id
        $id = filter_input(INPUT_GET, "id");
                
        //Get the vuelo based of the id
        $vuelo = $vuelos->getOneVuelo($id);
        //Show the array
        echo json_encode($vuelo);
        exit();
    }

    //Get from the model of vuelos all the vuelos as a json
    try {
        $vuelosJson = $vuelos->getAllVuelos();
    } catch (Exception $ex) {
        echo "Error consiguiendo vuelos, pruebe más tarde.";
        exit;
    }
    
    print_r($vuelosJson);
    
}//End of GET checking
