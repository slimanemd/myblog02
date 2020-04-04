<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  //doCataegoryCreating
  function doCategoryUpdating($data){
      global $db;
      
      $result = (CategoryManager::categoryFactory()($db))->update(
          ['id'   => htmlspecialchars(strip_tags($data->id))],
          ['name' => htmlspecialchars(strip_tags($data->name))]);
          //['id'   => htmlspecialchars(strip_tags($data['id']))],
          //['name' => htmlspecialchars(strip_tags($data['name']))]);
      return $result;
  }
  
  //read_main
  function update_main(){
      //api json encode / decode      // Get raw posted data
      $data = json_decode(file_get_contents("php://input"));      //$data = ['id'=>1, 'name'=>'ALI'];
      $result =  doCategoryUpdating($data);
      
      //
      echo(json_encode(
          array('message' => 'Category '. (($result == null )? 'Not ':'') .'Updated')
          ));
  }
?>