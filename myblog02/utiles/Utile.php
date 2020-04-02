<?php
//
include_once "../../config/Database.php";

//Utile
class Utile
{
  //getCategoryConnected  // Instantiate DB & connect  $db = new Database();  //$conn = $db->connect();
  public static function getEntityConnected($fcEntityFactory)
  {
    //echo json_encode( array('message' => 'No Categories Found2'));
    $conn = (new Database())->connect();
    $entity = $fcEntityFactory($conn);
    return $entity;
  }

  //Test DB connection
  public static function readProcessEntity($entityInfos, $entityFactory, $fc_preprocess, $fc_process, $fc_postprocess, $fc_errprocess)
  {
    //invoke read on CategoryConnected
    $result = Utile::getEntityConnected($entityFactory)->read(); //loop on result
    if ($result->rowCount() > 0) {
      $cat_arr = null;
      $fc_preprocess($cat_arr);
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {  //extract($row); echo($id."\t ". $name." <br>");
        $fc_process($row, $cat_arr);
      }
      $fc_postprocess($cat_arr);
    } else
      $fc_errprocess($entityInfos);
  }
}


  //read entities
  $dox = function($entityInfos, $entityFactory, $fcProcessing){
      Utile::readProcessEntity(
        $entityInfos,    //
        $entityFactory, 

        //preprocessing init 
        function(&$args){
          $args = array();
          $args['data'] = array();
        },

        //processing loop body & Push to "data"
        $fcProcessing,

        //postprocessing
        function(&$args){ echo json_encode($args); },

        //on error processing No Categories
        function($eInfos){ 
          echo(json_encode( array('message' => 'No Found'. $eInfos['name']))); 
        }
      );
      };

?>