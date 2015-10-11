<?php
/**
 * CorePHP
 * @author wherrera
 */
class Model {
    
    public function getTableName () {
        return false;
    }
    
    public function setValues($row) {
        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            if(isset($row[$prop->getName()])) {
                $prop->setValue($this, $row[$prop->getName()]);
            }
        }
        
        return true;
    }
    
    public function load($id) {
        
        if(!$this->getTableName()) {
            return false;
        }
        
        $db = DatabaseManager::getDatabase();
        
        $result = $db->query('select * from ' . $this->getTableName() . ' where id=' . $id);
        
        if(!$result) {
            return false;
        }
        
        $row = $db->fetchAssoc($result);
        
        if($row == NULL) {
            return false;
        }
        
        return $this->setValues($row);
    }
}

spl_autoload_register(function ($class) {
    $path = 'models/' . strtolower($class) . '.class.php';
    if(file_exists($path)) {
        include($path);
    }
});