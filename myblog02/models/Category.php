<?php
/*------------------------------------------------------------------*/
//
class CategoryEntity{
  // Properties
  public $id;
  public $name;
  public $created_at;

  //
  public function __construct()  {  }

  //
  public function setEntityProperties($row){
    foreach(array_keys($row) as $key) $this->$key = $row[$key];
  }

  //
  public function toString(){
    return $this->id . " ; " . $this->name;
  }
}
/*------------------------------------------------------------------*/

/*------------------------------------------------------------------*/
//
class CategoryManager
{
  // DB Stuff
  private $table = 'categories';
  public $entity;
  public $db;
  
  const TABLE = "categories";
  const FIELDS = ['id','name','created_at'];
  
  //Cat
  public function __construct($db, $entity){
    $this->db =  $db;
    $this->entity = $entity;
  }

  //Read from database  
  public function read($pParams = [])  //_single3
  {
    // set properties
    $query = (new Select(self::FIELDS))   //['id','name']
            ->from([self::TABLE])
            ->where(($pParams == [])?'*':'id = :id')  //            ->limit(0,1)
            ->orderby(['created_at'])
            ->query;
    return $this->db->doPrepExecGetStmts($query, $pParams);
  }

  // Create Category
  public function crud($operation, $pParams =[], $pSetMap=[]) {
      
      if($operation == 'read')
        $query = (new Select(self::FIELDS))   //['id','name']
            ->from([self::TABLE])
            ->where(($pParams == [])?'*':'id = :id')  //            ->limit(0,1)
            ->orderby(['created_at'])
            ->query;
      
      if($operation == 'create')
          $query = (new Insert(self::TABLE))->set(array_keys($pSetMap))->query;
      
      if($operation == 'update')
        $query = (new Update(['Tab'=> self::TABLE, 'Set'=>array_keys($pSetMap),'Cri'=>'id = :id']))->query;  //['name']
      
      if($operation == 'delete')
        $query = (new Delete(['Tab'=> self::TABLE, 'Cri'=>'id = :id']))->query; 
      
      //
      return $this->db->doPrepExecGetStmts($query, array_merge($pParams, $pSetMap));
  }
  
  
  // Create Category
  public function create($pParams) {      
      $query = (new Insert(self::TABLE))->set(array_keys($pParams))->query;  //['name']
      return $this->db->doPrepExecGetStmts($query, $pParams);
  }

  // Create Category
  public function update($pParams, $pSetMap) {
      $query = (new Update(['Tab'=> self::TABLE, 'Set'=>array_keys($pSetMap),'Cri'=>'id = :id']))->query;  //['name']
      return $this->db->doPrepExecGetStmts($query, array_merge($pParams, $pSetMap));
  }

  // Create Category
  public function delete($pParams) {
      $query = (new Delete(['Tab'=> self::TABLE, 'Cri'=>'id = :id']))->query;  //['name']
      return $this->db->doPrepExecGetStmts($query, $pParams);
  }
  
  //categoryFactory
  public static function categoryFactory() {
      return function ($db){ 
          return new CategoryManager($db, new CategoryEntity()); 
      };
  }
}

//$categoryFactory = function ($db){ return new CategoryManager($db, new CategoryEntity()); };

//
function Category_main(){
    global $db;
    
    print_r((CategoryManager::categoryFactory())($db)->update(['id'=> 1],['name'=>'DOM']));
}

//Test
//Category_main();

?>


