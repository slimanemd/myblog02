<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  //doCataegoryCreating
  function doCategoryDeleting($data){
      global $db;
      //echo(json_encode(array('message' => $data->id)));
      $result = (CategoryManager::categoryFactory()($db))->delete(
          ['id' => htmlspecialchars(strip_tags($data->id))]);  //['id'   => htmlspecialchars(strip_tags($data['id']))],
      return $result;
  }
  
  //read_main
  function delete_main(){
      //api json encode / decode      // Get raw posted data
      $data = json_decode(file_get_contents("php://input"));      //$data = ['id'=>8]; //, 'name'=>'ALI'];
      $result =  doCategoryDeleting($data);
      
      //
      echo(json_encode(
          array('message' => 'Category '. (($result == null )? 'Not ':'') .'Deleted')
      ));
  }
?>
