<?php
class Task {

    private $table;
    private $task_date;
    private $task;
    public function __construct($table = 'tasks', $task_date, $task) {
        $this->table = $table;
        $this->task_date = $task_date;
        $this->task = $task;
    }
    
    public function getTable() {
        return $this->table;
    }
    public function getTaskDate() {
        return $this->task_date;
    }
    public function getTask() {
        return $this->task;
    }
}
?>