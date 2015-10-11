<?php

/**
 * @author wherrera
 */
class User extends Model {
    public $id;
    public $name;
    public $created;
    
    public function getTableName() {
        return 'users';
    }
}