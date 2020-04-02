<?php

/* ------------------------------------------------------------------------------ */
//
class Database
{
    // DB Params
    public static $host = 'localhost';
    public static $db_name = 'dbmyblog';
    public static $username = 'aliben01';
    public static $password = 'Security_39';
    public static $conn;

    // DB Connect
    public static function connect()
    {
        //self::$conn = null;
        try {
            self::$conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name,
                                   self::$username, 
                                   self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if (Config::$_DEBUG) echo 'Connection OK' . '<br>';
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage() . '<br>';
        }        //return self::$conn;
    }

    // Get categories :Create query > Prepare statement > Execute query
    public static function doPrepExecGetStms($conn, $query)
    {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

/* ------------------------------------------------------------------------------ */
// Test DB connection
function Database_main()
{
    //$db = new Database();    //$db->connect();
    Database::connect();
}

// main
Database_main();
?>