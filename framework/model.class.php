<?php
/**
 * CorePHP
 * @author wherrera
 */
class Model {

    public function getTableName () {
        return false;
    }
    
    public function getPropertyValues () {
        $reflect = new ReflectionClass($this);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        $values = array();
        
        foreach ($props as $prop) {
            $values[$prop->getName()] = $prop->getValue($this);
        }
        
        return $values;
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
    
    public function update () {
        $values = $this->getPropertyValues();
        
        if(empty($values) || !isset($values['id'])) {
            return false;
        }
        
        unset($values['id']);
        
        $db = DatabaseManager::getDatabase();
        
        if(!$db->update($this->getTableName(), $values, array('id'=>$values['id']))) {
            return false;
        }
        
        return true;
    }
    
    public function insert () {
        $values = $this->getPropertyValues();
        
        if(empty($values)) {
            return false;
        }
        
        unset($values['id']);
        
        $db = DatabaseManager::getDatabase();
        
        if(!$db->insert($this->getTableName(), $values)) {
            return false;
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