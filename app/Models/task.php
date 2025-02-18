<?php
Class Task
{
    private $task;
    public $title;
    public $description;
    public function __construct(){
        $this->task = new Task();
    }

public function getTask(){
    return $this->task;
}
}
?>