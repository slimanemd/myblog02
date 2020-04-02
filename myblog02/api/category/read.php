<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //include_once('../../config/Database.php');
  include_once("../../utiles/Utile.php");
  include_once('../../models/Category.php');

  //processing loop body & Push to "data"
  $categoryProcessor = function($row, &$args){
    extract($row);  
    array_push($args['data'], 
      array(
        'id' => $id,
        'name' => $name
      )
    );
  };

  //
  $dox(
    array('name' => 'category'),   
    $categoryFactory, 
    $categoryProcessor);





  /*
  //read entities
  Utile::readProcessEntity(
    array('name' => 'category'),
    //
    $categoryFactory, 

    //preprocessing init 
    function(&$args){
      $args = array();
      $args['data'] = array();
    },

    //processing loop body
    function($row, &$args){
      extract($row);  // Push to "data"
      array_push($args['data'], array('id' => $id,'name' => $name ));
    },

    //postprocessing
    function(&$args){ echo json_encode($args); },

    //on error processing No Categories
    function(&$args){ echo json_encode( array('message' => 'No Categories Found')); }
    );
*/

  // // Instantiate DB & connect
  // $database = new Database();
  // $db = $database->connect();

  // // Instantiate category object
  // $category = new Category($db);

  // // Category read query
  // $result = $category->read();
  
  // // Get row count
  // $num = $result->rowCount();

  // // Check if any categories
  // if($num > 0) {
  //       // Cat array
  //       $cat_arr = array();
  //       $cat_arr['data'] = array();

  //       while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  //         extract($row);

  //         $cat_item = array(
  //           'id' => $id,
  //           'name' => $name
  //         );

  //         // Push to "data"
  //         array_push($cat_arr['data'], $cat_item);
  //       }

  //       // Turn to JSON & output
  //       echo json_encode($cat_arr);

  // } else {
  //       // No Categories
  //       echo json_encode(
  //         array('message' => 'No Categories Found')
  //       );
  // }






