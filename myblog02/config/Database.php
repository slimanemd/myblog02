<?php

/* ------------------------------------------------------------------------------ */
//
class Database
{
    // DB Params
    private $host = 'localhost';
    private $db_name = 'dbmyblog';
    private  $username = 'aliben01';
    private $password = 'Security_39';
    public $conn;
    
    //
    public function __construct(){
        $state_connect = $this->connect();   
        if($state_connect != "OK")  die('Die: ' . $state_connect);
    }
    
    // DB Connect
    public function connect()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     //if (Config::$_DEBUG) echo 'Connection OK' . '<br>';
            return "OK";
        } catch (PDOException $e) {
            return 'Exception.Message: ' . $e->getMessage();
        }     
    }
    
    //
    public function doPrepExecGetStmts($query, $pParams=[])
    {
        // Create query >  //Prepare statement >     // Bind ID >     // Execute query
        $stmt = $this->conn->prepare($query);
        if($pParams != []) foreach(array_keys($pParams) as $key) $stmt->bindParam(':'.$key, $pParams[$key]);
        if($stmt->execute()) {  return $stmt;  }    // Print error if something goes wrong
        print_r("Error: $.\n", $stmt->error);
        return null;
    }
}

/* ------------------------------------------------------------------------------ */
// Test DB connection
$db = null;

function Database_main()
{
    global $db;
    $db = new Database();
    //$query = "SELECT id, name, created_at FROM categories WHERE id = :id";
    //$stmt = $db->doPrepExecGetStmts($query,['id' => 1]);    //print_r($stmt);
}
?>