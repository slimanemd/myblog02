<?php

include_once "config/Config.php";
include_once("utiles/Utile.php");
include_once("config/Database.php");   Database_main();
include_once("config/Sqlquery.php");

//Dispatcher
if(isset($_GET['api'])){
    $args =  explode("/", $_GET['api']);
    if( in_array($args[0], ["category","post"]) && 
        in_array($args[1], ["read", "create","delete","update"])){

//         //$args[0]
//         include_once("models/Category". "" . ".php"); 
//         include_once("api/" . $args[0] . "/" . $args[1] . ".php");
        
//         $idSelected = (isset($args[2]))? ['id' => $args[2]] : [];
//         //($id0 == -1)? [] : ['id' => $id0]
//         //print_r($id);
        
//         if($args[1] == 'read'  ){ read_main(); }          //read  $id
//         if($args[1] == 'create'){ create_main();  }          //create
//         if($args[1] == 'update'){ update_main();  }          //update
//         if($args[1] == 'delete'){ delete_main();  }          //delete

           include_once("models/Category". "" . ".php");
           include_once("api/" . $args[0] . "/categorycrud.php");
           $OPR = $args[1];
           $idSelected = (isset($args[2]))? ['id' => $args[2]] : [];
           operation_main();
            
    
    }
}

?>
