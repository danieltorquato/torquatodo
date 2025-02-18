<?php
require __DIR__ . 'app/Config/db.php';
require_once 'Task.php';



class TaskController
{
    protected $db;

    protected $pdo;

    public function __construct()
    {
        $this->db = new Db();
        $this->pdo = $this->db->getConnection();
    }

    public function createTask($title, $description)
    {
        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $task->title);
        $stmt->bindParam(':description', $task->description);

        if ($stmt->execute()) {
            return "Task created successfully!";
        } else {
            return "Failed to create task.";
        }
    }

    public function getTasks()
    {
        $sql = "SELECT * FROM tasks";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>