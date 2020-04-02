<?php
  //
  //include_once "../config/Database.php";
  //include_once("../utiles/Utile.php");

//
class CategoryEntity{
  // Properties
  public $id;
  public $name;
  public $created_at;

  //
  public function __construct()
  {
  }

  //
  public function setEntityProperties($row){
    foreach(array_keys($row) as $key) $this->$key = $row[$key];
  }

  //
  public function toString(){
    return $this->id . " ; " . $this->name;
  }
}

//
class Category
{
  // DB Stuff
  private static $conn;
  private $table = 'categories';
  public $entity;

  // Constructor with DB
  public function __construct($db, $entity)
  {
    $this->conn = $db;
    $this->entity = $entity; // new CategoryEntity();
  }

  // Get categories :Create query > Prepare statement > Execute query
  public function read()
  {
    //$query = 'SELECT id, name, created_at FROM ' . $this->table . ' ORDER BY created_at DESC';
    $query = (new Select(['id','nm:name','created_at']))
            ->from(['category'])
            ->orderby(['created_at'])
            ->query;

    //$stmt = $this->conn->prepare($query); 
    //$stmt->execute();
    //return $stmt;
    return $this->doPrepExecGetStms($this->conn, $query);

  }

  // Get categories :Create query > Prepare statement > Execute query
  public function doPrepExecGetStms($conn, $query)
  {
    $stmt = $conn->prepare($query); 
    $stmt->execute();
    return $stmt;
  }


  // Get Single Category
  public function read_single($pParams)
  {
    // set properties
    $stmt = $this->read_single3($pParams);    //echo($row);    //print_r($stmt);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);    //print_r($row);
    $this->entity->setEntityProperties($row);   //$this->id = $row['id'];//$this->name = $row['name'];
  }

  //
  public function read_single3($pParams)
  {
    // Create query >  //Prepare statement >     // Bind ID >     // Execute query
    $query = 'SELECT id, name FROM ' . $this->table . ' WHERE id = :id LIMIT 0,1';
    $stmt = $this->conn->prepare($query);
    foreach(array_keys($pParams) as $key) $stmt->bindParam(':'.$key, $pParams[$key]);  
    $stmt->execute();    
    return $stmt;
  }


  // Create Category
  public function create()
  {
    $this->entity->name = htmlspecialchars(strip_tags($this->entity->name));

    // Create Query     // Prepare Statement     // Clean data     // Bind data      // Execute query
    $query = 'INSERT INTO ' . $this->table . 'SET name = :name';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $this->entity->name);
    if ($stmt->execute())  return true;     // Print error if something goes wrong
    printf("Error: $.\n", $stmt->error);
    return false;
  }


  // Update Category
  public function update()
  {
    //
    $this->entity->name = htmlspecialchars(strip_tags($this->entity->name));
    $this->entity->id = htmlspecialchars(strip_tags($this->entity->id));

    // Create Query     // Prepare Statement     // Clean data     // Bind data      // Execute query
    $query = 'UPDATE ' .  $this->table . '  SET   name = :name    WHERE     id = :id';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':id', $this->id);
    if ($stmt->execute()) return true;    // Print error if something goes wrong
    printf("Error: $.\n", $stmt->error);
    return false;
  }

  // Delete Category
  public function delete()
  {
    // Create query // Prepare Statement  // clean data     // Bind Data     // Execute query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';    
    $stmt = $this->conn->prepare($query);   
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(':id', $this->id);
    if ($stmt->execute()) return true;     // Print error if something goes wrong
    printf("Error: $.\n", $stmt->error);
    return false;
  }
}

//
$categoryFactory = function ($conn){ return new Category($conn, new CategoryEntity()); };

//main
function main2(){
  if(Config::$_DEBUG) echo('Category bg' . '<br>');
  $ctg =  new Category((new Database())->connect(), new CategoryEntity());
  $ctg->read_single(['id'=>2]);  //$ctg->entity->toString()v
  echo($ctg->entity->toString() . '<br>');
  if(Config::$_DEBUG) echo('Category ed' . '<br>');
}


//
function main(){

}




//Test
main();


  /*
  //main     //
  Utile::readProcessEntity(
    array('name' => 'category'),
    $categoryFactory, 
    function(&$args){ echo(" Preproc : xx - msg : " . $args[0] . "<br>");   },
    function($row, &$args){ 
      extract($row);    //array('id' => $id,'name' => $name )
      echo(" Proc    : xx - msg : " . $id . "    " . $name . "<br>");  },
    function(&$args){ echo(" PostProc: xx - msg : " . $args[0] . "<br>");  },
    function(&$args){ echo('no data ' . $args['name']); }
    );
  */
?>


