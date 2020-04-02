<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //include_once('../../config/Database.php');
  include_once("../../utiles/Utile.php");
  include_once('../../models/Post.php');

  //processing loop body & Push to "data"
  $postProcessor = function($row, &$args){
    extract($row);  
    array_push($args['data'], 
      array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name
      )
    );
  };

  //
  $dox(
    array('name' => 'post'),   
    $postFactory, 
    $postProcessor);





  /*
  $postProc =     //processing loop body & Push to "data"

  $dox(array('name' => 'post'), $postFactory, $postProc, $postProc);
*/

 //read entities
  Utile::readProcessEntity(
    array('name' => 'post'),

    //
    $postFactory, 

    //preprocessing init 
    function(&$args){
      $args = array();
      $args['data'] = array();
    },

    //processing loop body & Push to "data"
    function($row, &$args){
      extract($row);  
      array_push($args['data'], 
        array(
          'id' => $id,
          'title' => $title,
          'body' => html_entity_decode($body),
          'author' => $author,
          'category_id' => $category_id,
          'category_name' => $category_name
        )
      );
    },

    //postprocessing
    function(&$args){ echo json_encode($args); },

    //on error processing No Categories
    function($args){ echo json_encode( array('message' => 'No ' . $args['name'] . ' Found')); }
    );
 

  /* 
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Blog post query
  $result = $post->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name
      );

      // Push to "data"
      array_push($posts_arr, $post_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
 */