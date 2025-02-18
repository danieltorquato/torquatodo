<?php
class Task {

    private $table;
    private $task_date;
    public function __construct($db) {
 
    }
    
    public function getTable() {
        return $this->table;
    }

}
?>