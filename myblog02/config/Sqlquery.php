<?php

/*
SELECT
    [ALL | DISTINCT | DISTINCTROW ]
    [HIGH_PRIORITY]
    [STRAIGHT_JOIN]
    [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
    [SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS]
    select_expr [, select_expr] ...    [into_option]
    [FROM table_references   [PARTITION partition_list]]
    [WHERE where_condition]
    [GROUP BY {col_name | expr | position}, ... [WITH ROLLUP]]
    [HAVING where_condition]
    [WINDOW window_name AS (window_spec)        [, window_name AS (window_spec)] ...]
    [ORDER BY {col_name | expr | position}   [ASC | DESC], ... [WITH ROLLUP]]
    [LIMIT {[offset,] row_count | row_count OFFSET offset}]    [into_option]
    [FOR {UPDATE|SHARE} [OF tbl_name [,tbl_name]...][NOWAIT | SKIP LOCKED]|LOCK IN SHARE MODE][into_option]

into_option: { INTO OUTFILE 'file_name'
        [CHARACTER SET charset_name]
        export_options
  | INTO DUMPFILE 'file_name'
  | INTO var_name [, var_name] ...
}
*/

//
class Query{
    //
    public $query="";
    
    //adr = [ALL | DISTINCT | DISTINCTROW ]
    public function __construct()
    {
    }
    
    //
    public function from($table_references){ $this->query .= ("FROM ".join($table_references, ", "));
    return $this;
    }
    
    //
    public function where($condition){
        if($condition != '*') $this->query .= " WHERE " . $condition;
        return $this;    }
        
    public function limit($offset,  $row_count){ $this->query .= " LIMIT " . $offset . ',' . $row_count; return $this; }
    public function orderby($cxps, $option = 'ASC'){ $this->query .= " ORDER BY " . ("".join($cxps, ", ")) . " ". $option; return $this; }
    public function groupby($cxps, $option = 'ASC'){ $this->query .= " GROUP BY " . ("".join($cxps, ", ")) . $option; return $this; }
    public function having($cxps, $option = 'ASC'){ $this->query .= " GROUP BY " . ("".join($cxps, ", ")) . $option; return $this; }
    
//     //
//     public function set($pSetMap){
//         $keyscolonKeys = array_map(
//             function($key){ return $key . " = :" . $key; },
//             array_keys($pSetMap));
//         $this->query .= "SET ".join($keyscolonKeys, ", ");
//         return $this;
//     }        

    //(Field = :Field)+
    public function set($pFields){
        $keyscolonKeys = array_map( function($key){ return $key . " = :" . $key; }, $pFields);
        $this->query .= "SET ".join($keyscolonKeys, ", ");
        return $this;
    }
    

}

//
class Select extends Query{
  //adr = [ALL | DISTINCT | DISTINCTROW ]
  public function __construct($select_expr_list, $adr = 'ALL')
  {
    $exprs = ($select_expr_list == [])? '*' : join($select_expr_list, ", ");
    $this->query="SELECT " . $exprs . " ";
    $this->query = str_replace(':',' as ', $this->query);
    if (in_array($adr, ['DISTINCT','DISTINCTROW'])) $this->query .= $adr . " ";
  }

//   //
//   public function from($table_references){ $this->query .= ("FROM ".join($table_references, ", ")); 
//     return $this;   
//   }
//   public function where($condition){ 
//       if($condition != '*') $this->query .= " WHERE " . $condition;  
//       return $this;    }
//   public function limit($offset,  $row_count){ $this->query .= " LIMIT " . $offset . ',' . $row_count; return $this; }
//   public function orderby($cxps, $option = 'ASC'){ $this->query .= " ORDER BY " . ("".join($cxps, ", ")) . " ". $option; return $this; }
//   public function groupby($cxps, $option = 'ASC'){ $this->query .= " GROUP BY " . ("".join($cxps, ", ")) . $option; return $this; }
//   public function having($cxps, $option = 'ASC'){ $this->query .= " GROUP BY " . ("".join($cxps, ", ")) . $option; return $this; }  
}

//$query = (new Insert(self::TABLE))->set( array_keys($pSetMap) )->query;  //['name']
class Insert extends Query{   
    //adr = [ALL | DISTINCT | DISTINCTROW ]
    public function __construct($pTable)
    {
        $this->query="INSERT INTO " . $pTable . " ";
    }
}

//$query = (new Insert(self::TABLE))->set( array_keys($pSetMap) )->query;  //['name']
class Update  extends Query{    
    //
    public function __construct($pParams)
    {
        // $pTable,$pSetMap, $pCritiria
        $this->query="UPDATE " . $pParams['Tab'] . " ";
        $this->set($pParams['Set'])->where($pParams['Cri']);  //['name']
    }
}

//$query = (new Insert(self::TABLE))->set( array_keys($pSetMap) )->query;  //['name']
class Delete  extends Query{
    //
    public function __construct($pParams)
    {
        // $pTable,$pSetMap, $pCritiria
        $this->query="DELETE FROM " . $pParams['Tab'] . " ";
        $this->where($pParams['Cri']);  //['name']
    }
}

//
class Builder{
  //
  public $query="";

  //
  public function __construct()
  {
    $query="";
  }

  //
  public function select($fields){
    $this->query .= "SELECT " . ("".join($fields, ", "));
    return $this;
  }

  //
  public function from($table){
    $this->query .= " FROM " . $table;
    return $this;
  }

    //
    public function where($critiria){
      $this->query .= " WHERE " . $critiria;
      return $this;
    }

        //
        public function limit($range){
          $this->query .= " LIMIT " . $range[0] . ',' . $range[1];
          return $this;
        }

    //
    public function orderby($fields){
      $this->query .= " ORDER BY " . ("".join($fields, ", "));
      return $this;
    }
}

//
function sqlquery_main(){
  $bl =  new Builder();
  $q = ($bl->select(['id','nm:name','created_at']))
           ->from('category')
           ->orderby(['created_at'])
           ->query;
  echo($q . '<br>');
           
  $bl->query = '';
  $q = ($bl->select(['id','name']))
           ->from('category')
           ->where('id = :id')
           ->limit([0,1])
           ->query;           
  echo($q . '<br>');

  $sq =  (new Select(['id','nm:name','created_at']))
            ->from(['category'])
            ->orderby(['created_at'])
           ->query;
  echo($sq . '<br>');

  
  $sq =  (new Select(['1 + 1']))->query;   echo($sq . '<br>');                //SELECT 1 + 1;        -> 2
  $sq =  (new Select(['1 + 1']))->from(['DUAL'])->query;   echo($sq . '<br>');  //mysql> SELECT 1 + 1 FROM DUAL;
  $sq =  (new Select([]))->from(['DUAL'])->query;   echo($sq . '<br>');  //mysql> SELECT 1 + 1 FROM DUAL;

}

//main();

?>











