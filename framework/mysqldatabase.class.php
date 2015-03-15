<?php
/**
 * @author wherrera
 */
class MySQLDatabase
{
    private $mysqli = null;
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $connected = FALSE;
    
    public function MySQLDatabase ($hostname,$username,$password,$dbname) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;        
    }
    
    /**
     * @return: mysqli
     */
    private function getMysqli() {
        return $this->mysqli;
    }
    
    public function connected () {
        if($this->mysqli == null) {
            return FALSE;
        }
        return $this->connected;
    }
    
    public function connect () {
        $this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if ($this->mysqli->connect_errno) {
            $this->connected = FALSE;
            return FALSE;
        }
        $this->connected = TRUE;
        return TRUE;
    }
    
    public function insertedId() {        
        return $this->getMysqli()->insert_id;
    }
        
    public function query ($query) {
        if(!$this->connected) {
            return FALSE;
        }
        return $this->mysqli->query($query);
    }
    
    public function queryAsAssocArray ($query) {
        $result = $this->query($query);
        if($result == FALSE) {
            return FALSE;
        }
        $rows = array();
        while($row = $this->fetchAssoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    public function count ($table,$where) {
        $row = $this->fetchRow($this->query("select count(*) from " . $table . ' ' . $where));
        return intval( $row[0] );
    }
    
    public function fetchAssoc (mysqli_result $result) {
        return $result->fetch_assoc();
    }
    
    public function fetchRow (mysqli_result $result) {
        return $result->fetch_row();
    }
        
    public function real_escape_string($str) {
        return $this->mysqli->real_escape_string($str);
    }
    
    public function startTransaction() {
        return $this->query('START TRANSACTION;');
    }
    
    public function commit() {
        return $this->query('COMMIT;');
    }
    
    public function rollback() {
        return $this->query('ROLLBACK;');
    }

    /**
     * @return mysqli_stmt <b>mysqli_prepare</b> returns a statement object or <b>FALSE</b> if an error occurred.
     */
    public function prepare($query) {
        return $this->mysqli->prepare($query);
    }
        
    /**
     * @return: mysqli_stmt
     */
    public function select ( $table, array $values) 
    {        
        $query = "select * from $table where ";
        $keys = "";
        $types = "";  
        $refArr = array();        
        foreach ($values as $key => $value) {
            if(strlen($keys) > 0) {
                $keys .= " and ";
            }                 
            if (is_integer($value)) {
                $keys .= $key . "=$value ";    
            } else {
                $keys .= $key . "='$value' ";    
            }
        }        
        $query .= $keys;
        return $this->query($query);
    }
    
    /**
     * Executes a update Query
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */    
    public function update ( $table, array $values , array $where) 
    {        
        $query = "update $table set ";
        $keys = "";
        $types = "";  
        $refArr = array();
        foreach ($values as $key => $value) {
            if(strlen($keys) > 0) {
                $keys .= ",";
            }
            $keys .= $key . ' = ?';            
            if (is_integer($value)) {
                $types .= "i";
            } else {
                $types .= "s";
            }
            $refArr[] = &$values[$key];
        }        
        if(count($where) > 0) {            
            $whereKeys='';
            foreach ($where as $key => $value) {
                if(strlen($whereKeys) > 0) {
                    $whereKeys .= " and ";
                }
                $whereKeys .= $key . ' = ?';            
                if (is_integer($value)) {
                    $types .= "i";
                } else {
                    $types .= "s";
                }                
                $refArr[] = &$where[$key];
            }
            $keys .= ' where ' . $whereKeys;
        }        
        $bind_args = array_merge( array($types), $refArr);        
        $query .= $keys;        
        $res    = $this->prepare($query);
        if( $res == FALSE ) {
            Logger::Warning('update prepare failed for table ' . $table);
            return FALSE;
        }       
        if( call_user_func_array(array($res, "bind_param"), $bind_args) == false ) {
            Logger::Warning('call to bind_param failed for update table ' . $table);
            return FALSE;
        }
        $execute_result = $res->execute();            
        return $execute_result && ($res->affected_rows > 0);
    }
    
    /**
     * Executes a insert Query
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function insert ( $table, array $values ) 
    {        
        $query = "insert into $table ";
        $keys = "";
        $types = "";  
        $refArr = array();        
        foreach ($values as $key => $value) {
            if(strlen($keys) > 0) {
                $keys .= ",";
            }
            $keys .= $key;            
            if(is_string($value)) {
                $types .= "s";
            } else if (is_integer($value)) {
                $types .= "i";
            } else {
                $types .= "s";
            }
        }
        $refArr[] = $types;
        foreach ($values as $key => $value) {
            $refArr[] = &$values[$key];
        }
        $query .= "($keys) values(";                
        for($i=0;$i<count($values);$i++) {
            if($i>0) $query .= ",";
            $query .= "?";            
        }        
        $query .= ")";       
        $res    = $this->mysqli->prepare($query);  
        if($res == FALSE) {
            Logger::Warning('insert prepare failed for table ' . $table);
            return FALSE;
        }
        $ref    = new ReflectionClass('mysqli_stmt');
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($res,$refArr);
        return $res->execute();   
    }

    public function close () {
        if($this->mysqli != null) {
            $this->mysqli->close();
        }
    }
    
    public function connectError () {        
        return mysqli_connect_error();
    }
    
    public function error() {
        return $this->mysqli->error;
    }
    
    public function errorNumber() {
        return $this->getMysqli()->errno;
    }
}