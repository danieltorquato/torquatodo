<?php
class Task {

    private $table;
    private $task_date;
    private $task;
    private $user;
    public function __construct($table = 'tasks', $task_date, $task, $user) {
        $this->table = $table;
        $this->task_date = $task_date;
        $this->task = $task;
        $this->user = $user;
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
    public function getUser() {
        return $this->user;
    }
}
?>