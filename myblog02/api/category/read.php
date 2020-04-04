<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

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
          ($id0 == -1)? [] : ['id' => $id0],     //$categoryParams,
          CategoryManager::categoryFactory(),  // $categoryFactory
          function(){  $args = array(); $args['data'] = array(); return $args; },  //init
          $categoryProcessor); //processing
          
          return $result;
  }
  
  //read_main //api json encode / decode
  function read_main(){  //$id=-1
      global $idSelected;
      
      $data = $idSelected;  //json_decode(file_get_contents("php://input"));
      $result =  doCategoryReading($data);
      echo(json_encode( 
            ($result == null)? array('message' => 'No Found '. 'Category') : $result ));
    }
?>