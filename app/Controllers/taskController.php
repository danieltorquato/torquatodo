<?php
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Models/task.php';

class TaskController {
    private $table;
    private $task_date;
    public $task;
    private $pdo;

    public $id;
    public function __construct() {
        $db = new Db();
        $task = new Task($this->table, $this->task_date, $this->task);
    $this->pdo = $db->getConnection();
    $this->task = $task->getTask();
    $this->table = $task->getTable();
    }

    public function getTasks() {

       
        $query = 'SELECT * FROM tasks';
        $find = $this->pdo->prepare($query);
        $find->execute();
        if ($find->rowCount() > 0) {
            $this->task = $find->fetchAll(PDO::FETCH_ASSOC);
            return $this->task;
        }else{
            echo 'Nenhuma tarefa encontrada';
        }
       
    }
   public function addTask() {
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    if($description){
        try {
            $this->pdo->beginTransaction();
           $query = $this->pdo->prepare('INSERT INTO tasks (user_id, description, completed, created_at, completed_at, task_date ) VALUES (1, ?,1, NOW(), NOW(), NOW())');
           $query->execute([
        $description
           ]);
           $this->pdo->commit();
           echo "Cadastro realizado com sucesso!";
           header("Location: ../../index.php");
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
        }
      
    }
}
    
}
$task = new TaskController();
$task->addTask();

?>