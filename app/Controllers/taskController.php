<?php
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Models/task.php';
require_once __DIR__ . '/../routes/taskRoutes.php';

class TaskController {
    private $table;
    public $task_date;
    public $task;
    private $pdo;
    public $id;
    public $input;
 public $user;

public $selectedDate;
public $task_date_test;
    public function __construct() {
        $db = new Db();
        $task = new Task($this->table, $this->task_date, $this->task, 2);
        $this->pdo = $db->getConnection();
        $this->table = $task->getTable();
        $this->task_date = $task->getTaskDate();
        $this->user = $task->getUser();
        $this->task_date_test = date('Y-m-d');
       
    }

    public function getTasks($user, $taskDate) {
              
        $query = 'SELECT * FROM tasks WHERE user_id=? AND task_date=?';
        $find = $this->pdo->prepare($query);
        $find->execute([
            $user,
            $taskDate
        ]);
        if ($find->rowCount() > 0) {
            $this->task = $find->fetchAll(PDO::FETCH_ASSOC); 
     
            return $this->task;
        }else{
          
            return $this->task = [];
        }
    }
    
    

    public function getTaskDate()
    {
        return $this->task_date;
    }
    public function addTask($id, $taskDate, $description)
    {
      
        if ($description) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare('INSERT INTO tasks (user_id, description, completed, created_at, completed_at, task_date ) VALUES (?, ?,0, NOW(), NOW(), ?)');
                $query->execute([
                    $id,
                    $description,
                    $taskDate
                ]);
                $this->pdo->commit();
                header("Location: ../../index.php?date=" . $taskDate);

                echo "Cadastro realizado com sucesso!";
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo "Erro ao cadastrar usuário: " . $e->getMessage();
            }

        }
    }
    public function editTask($taskDate)
    {
        $taskEdit = filter_input(INPUT_POST, 'edit-text');
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        var_dump($taskEdit, $taskId); 

        if ($taskId) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare('UPDATE tasks SET description=? WHERE id=?');
                $query->execute([
                    $taskEdit,
                    $taskId
                ]);
                $this->pdo->commit();
                echo "Cadastro atualizado com sucesso!";
                header("Location: ../../index.php?date=" . $taskDate);
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo 'Não foi possível atualizar: ' . $e->getMessage();
            }
        }
    }
    public function completedTask($taskDate)
    {
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        if ($taskId) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare('UPDATE tasks SET completed = 1 WHERE id=?');
                $query->execute([
                    $taskId
                ]);
                $this->pdo->commit();
               header("Location: index.php?date=" . $taskDate);
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo 'Erro ao completar tarefa: ' . $e->getMessage();
            }

        }
    }

    public function uncompletedTask($taskDate){
        $taskId = $_POST['taskId'];
        if ($taskId) {
        try{
            $this->pdo->beginTransaction();
            $query = $this->pdo->prepare('UPDATE tasks SET completed = 0 WHERE id=?');
            $query->execute([$taskId]);
            $this->pdo->commit();
            header("Location: index.php?date=" . $taskDate);
        }catch (Exception $e) {
            $this->pdo->rollBack();
            echo 'Erro ao completar tarefa: ' . $e->getMessage();
        }

        }
    }
    public function deleteTask($taskDate)
    {
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        if ($taskId) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare("DELETE FROM tasks WHERE id=? ");
                $query->execute([
                    $taskId
                ]);
                $this->pdo->commit();
                header("Location: ../../index.php?date=" . $taskDate); 
            } catch (Exception $e) {
                echo 'Erro ao deletar :' . $e->getMessage();
            }
        }
    }

}
$tasks = new TaskController();
?>