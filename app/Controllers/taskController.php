<?php
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Models/task.php';
require_once __DIR__ . '/../routes/taskRoutes.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
  
class TaskController {
    private $table;
    private $task_date;
    public $task;
    private $pdo;
    public $id;
    public $input;
 
    public function __construct($data) {
        $db = new Db();
        $task = new Task($this->table, $this->task_date, $this->task);
        $this->pdo = $db->getConnection();
        $this->task = $task->getTask();
        $this->table = $task->getTable();
        $this->task_date = $task->getTaskDate();
       
        $this->getTasks($data);
    }

    public function getTasks($data) {
        $router = new TaskRouter();
        $data= $router->getTaskDate();
        if ($data === null) {
            error_log("Erro ao decodificar o JSON: " . json_last_error_msg());
       
        }

        // Verifica se a data foi recebida no corpo da requisição
        $selectedDate = $data['selectedDate'] ?? null;
        error_log("Data selecionada: " . $selectedDate); // Adiciona esta linha para verificar o valor de $selectedDate

     

        // if ($selectedDate != null) {
        //     // Converte a data para o formato Y-m-d para a consulta
        //     $this->task_date = $selectedDate;

        //     // Prepara a consulta
        //     $user = 2;
        //     $query = 'SELECT * FROM tasks WHERE user_id=? AND task_date=?';
        //     $find = $this->pdo->prepare($query);
        //     $find->execute([$user, $this->task_date]);

        //     if ($find->rowCount() > 0) {
        //         $this->task = $find->fetchAll(PDO::FETCH_ASSOC);
        //         echo json_encode($this->task);  // Retorna as tarefas como JSON
        //     } else {
        //         echo json_encode([]);  // Retorna um array vazio caso não haja tarefas
        //     }
        // } else {
        //     echo json_encode(['error' => 'Data não fornecida']);  // Retorna um erro caso a data não seja fornecida
        // }
    }
    

    public function getTaskDate()
    {
        return $this->task_date;
    }
    public function addTask()
    {
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        if ($description) {
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
    public function editTask()
    {
        $taskEdit = filter_input(INPUT_POST, 'edit-text');
        $taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
        var_dump($taskEdit, $taskId);  // Adicione essa linha para verificar os dados recebidos

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
                header("Location: ../../index.php");
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo 'Não foi possível atualizar: ' . $e->getMessage();
            }
        }
    }
    public function completedTask()
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
                header("Location: ../../index.php");
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo 'Erro ao completar tarefa: ' . $e->getMessage();
            }

        }
    }
    public function deleteTask()
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
                header("Location: ../../index.php");
            } catch (Exception $e) {
                echo 'Erro ao deletar :' . $e->getMessage();
            }
        }
    }

}

?>