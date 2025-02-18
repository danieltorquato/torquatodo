<?php
require_once 'app/Config/db.php';
require_once 'app/Models/task.php';

class TaskController {
    private $task;

    public function __construct($db) {
        $this->task = new Task($db);
    }

   
}
?>