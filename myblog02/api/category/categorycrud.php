<?php

$oprs = array('read'=> 'GET', 'create'=>'POST', 'update'=>'PUT', 'delete'=>'DELETE');


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');   //read $OPR
header('Access-Control-Allow-Methods: '. $oprs[$OPR]);  //update
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

//header('Access-Control-Allow-Methods: PUT');  //update
//header('Access-Control-Allow-Methods: POST');  //create
//header('Access-Control-Allow-Methods: DELETE'); //delete


//doCataegoryReading
function doCategoryReading($id0){
    //processing loop body & Push to "data"
    $categoryProcessor = function($row, &$args){
        extract($row);
        $item = array(
            'id' => $id,
            'name' => $name );
        array_push($args['data'], $item );
    };
    
    //
    $result = Utile::readProcessEntity(
        $id0,     //$categoryParams, ($id0 == -1)? [] : ['id' => $id0]
        CategoryManager::categoryFactory(),  // $categoryFactory
        function(){  $args = array(); $args['data'] = array(); return $args; },  //init
        $categoryProcessor); //processing
        
        return $result;
}

//---------------------------------------------
//read_main       //api json encode / decode      // Get raw posted data
function operation_main(){  //$id=-1
    global $db;
    global $idSelected;
    global $OPR;
    
    if($OPR == "read"){
        $result = doCategoryReading($idSelected);
        $result = ($result == null)? array('message' => 'No Found '. 'Category') : $result;
    }
    else {
        $data = json_decode(file_get_contents("php://input"));
        $result = (CategoryManager::categoryFactory()($db))->crud(
            $OPR, 
            ($OPR != "create")? ['id'   => htmlspecialchars(strip_tags($data->id))]:[],  //update, delete
            ($OPR != "delete")? ['name' => htmlspecialchars(strip_tags($data->name))]:[] //create, update
            );
        $result = array('message' => 'Category '. (($result == null )? 'Not ':'') . $OPR . 'd');
    }
    
    echo(json_encode($result));
}
//---------------------------------------------
?>