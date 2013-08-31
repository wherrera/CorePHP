<?php
/**
 *
 * @author wherrera
 */
interface Database {
    public function connect ();
    public function insertedId ();
    public function query ($query);
    public function queryAsAssocArray ($query);
    public function count ($table, $where);
    public function fetchAssoc ($result);
    public function fetchRow ($result);
    public function real_escape_string ($str);
    public function startTransaction ();
    public function commit ();
    public function rollback ();
    public function prepare ($query);
    public function select ( $table, array $values);
    public function update ( $table, array $values , array $where);
    public function insert ( $table, array $values );
    public function close ();
    public function connectError ();
    public function error ();
    public function errorNumber ();
}
?>