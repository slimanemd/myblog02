<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  //doCataegoryCreating
  function doCataegoryCreating($data){
      global $db;
      $result = (CategoryManager::categoryFactory()($db))->create(
          ['name' => htmlspecialchars(strip_tags($data->name))]);  
      return $result;
  }
  
  //read_main       //api json encode / decode      // Get raw posted data
  function create_main(){
      $data = json_decode(file_get_contents("php://input"));
      $result =  doCataegoryCreating($data);
      echo(json_encode(
          array('message' => 'Category '. (($result == null )? 'Not ':'') .'Created')
          ));
  }
?>