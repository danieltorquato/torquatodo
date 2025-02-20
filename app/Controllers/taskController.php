<?php
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Models/task.php';

class TaskController {
    private $table;
    private $task_date ;
    public $task;
    private $pdo;

    public $id;
    public function __construct() {
        $db = new Db();
        $task = new Task($this->table, $this->task_date , $this->task);
    $this->pdo = $db->getConnection();
    $this->task = $task->getTask();
    $this->table = $task->getTable();
    $this->task_date = date("Y-m-d");
    }

    public function getTasks() {

       $user = 2;
        $query = 'SELECT * FROM tasks WHERE user_id=?';
        $find = $this->pdo->prepare($query);
        $find->execute([
            $user
        ]);
        if ($find->rowCount() > 0) {
            $this->task = $find->fetchAll(PDO::FETCH_ASSOC);
            return $this->task;
        }else{
          
            return $this->task;
           
        }
       
    }
    public function getTaskDate() {
        return $this->task_date;
    }
   public function addTask() {
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    if($description){
        try {
            $this->pdo->beginTransaction();
           $query = $this->pdo->prepare('INSERT INTO tasks (user_id, description, completed, created_at, completed_at, task_date ) VALUES (2, ?,0, NOW(), NOW(), NOW())');
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
public function editTask(){
    $taskEdit = filter_input(INPUT_POST, 'edit-text');
    $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
    var_dump($taskEdit, $taskId);  // Adicione essa linha para verificar os dados recebidos

    if($taskId){
        try {
            $this->pdo->beginTransaction();
            $query= $this->pdo->prepare('UPDATE tasks SET description=? WHERE id=?');
            $query->execute([
                $taskEdit,
                $taskId
            ]);
            $this->pdo->commit();
            echo "Cadastro atualizado com sucesso!";
            header("Location: ../../index.php");
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo 'Não foi possível atualizar: ' . $e->getMessage();
        }
    }
}
    public function completedTask(){
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        if($taskId){
            try {
                $this->pdo->beginTransaction();
            $query = $this->pdo->prepare('UPDATE tasks SET completed = 1 WHERE id=?');
            $query->execute([
                $taskId
            ]);
            $this->pdo->commit();
            header("Location: ../../index.php");
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo 'Erro ao completar tarefa: ' . $e->getMessage();
            }
            
        }
    }
    public function deleteTask(){
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        if($taskId){
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare("DELETE FROM tasks WHERE id=? ");
                $query->execute([
                    $taskId
                ]);
                $this->pdo->commit();
                header("Location: ../../index.php");
            } catch (Exception $e) {
                echo 'Erro ao deletar :' . $e->getMessage();
            }
        }
    }
 
}

?>