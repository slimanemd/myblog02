<?php
////include_once "../../config/Database.php";

//Utile
class Utile
{
//     //Test DB connection
//     public static function readProcessEntity(
//         $entityInfos,
//         $entityParams = [],
//         $fc_entityFactory,
//         $fc_onProcess,
//         $fc_preProcess,
//         $fc_postProcess,
//         $fc_errProcess )
//     {
//         global $db;
        
//         //invoke read on CategoryConnected Utile::getEntityConnected($entityFactory)->read(); //loop on result
//         $result = $fc_entityFactory($db)->read($entityParams); //loop on result    //print_r($result);
        
//         //processing
//         if ($result->rowCount() > 0) {
//             $cat_arr = null;
//             $fc_preProcess($cat_arr);
//             while ($row = $result->fetch(PDO::FETCH_ASSOC)) $fc_onProcess($row, $cat_arr);
            
//             $fc_postProcess($cat_arr);
//         } else
//             $fc_errProcess($entityInfos);
//     }
    //---------------------------------------------------
    
//   //Test DB connection
//   public static function readProcessEntity3(
//       $entityInfos, 
//       $entityParams,
//       $fc_entityFactory,
//       $fc_onProcess,
//       $fc_preProcess,  
//       $fc_postProcess, 
//       $fc_errProcess)
//   {
//       $result = Utile::readProcessEntity2(
//           $entityParams,
//           $fc_entityFactory,
//           $fc_preProcess,
//           $fc_onProcess);
      
//      //
//      if($result == null) $fc_errProcess($entityInfos);
//      $fc_postProcess($result);     
//   }
//---------------------------------------------------
  //Test DB connection
  public static function readProcessEntity(
      $entityParams,
      $fc_entityFactory,
      $fc_preProcess,
      $fc_onProcess)
  {
      global $db;
      
      //invoke read on CategoryConnected Utile::getEntityConnected($entityFactory)->read(); //loop on result
      $result = $fc_entityFactory($db)->read($entityParams); //loop on result 
      if ($result->rowCount() > 0) {          //$cat_arr = null;    $fc_preprocess($cat_arr);
          $cat_arr = $fc_preProcess();
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) $fc_onProcess($row, $cat_arr);
          return $cat_arr;
      }
      return null;
  }
}

// //read entities partial
// $partialreadProcessEntity = function(
//     $entityInfos, 
//     $entityParams = [],
//     $fc_entityFactory, 
//     $fc_entityProcessor){
//     Utile::readProcessEntity3(
//         $entityInfos,                                                    //
//         $entityParams,
//         $fc_entityFactory,                                                  //preprocessing init
//         $fc_entityProcessor,                                                //postprocessing
//         function(){  $args = array(); $args['data'] = array(); return $args; }, //processing loop body & Push to "data"
//         function(&$args){ echo(json_encode($args)); },                         //on error processing No Categories
//         function($eInfos){ echo(json_encode( array('message' => 'No Found'. $eInfos['name']))); }        
//       );
//       };
      
//       //        function(&$args){  $args = array(); $args['data'] = array();  }, //processing loop body & Push to "data"
?>






