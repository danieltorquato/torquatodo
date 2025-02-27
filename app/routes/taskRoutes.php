<?php
require_once __DIR__ . '/../Controllers/taskController.php';

class TaskRouter {
    private $taskController;
    public $task;
    public function __construct() {
        $this->taskController = new TaskController();

       
    }
    public function handleRequest() {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'add':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $description = $_POST['description'] ?? null;
                    $taskDate = $_POST['taskDate'] ?? date('Y-m-d');
                    
                    if ($description && $taskDate) {
                        $this->taskController->addTask($taskDate, $description);
                    } else {
                        echo json_encode(["error" => "Dados insuficientes para adicionar a tarefa"]);
                    }
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'complete':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->completedTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->deleteTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->editTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            default:
           $this->task = $this->taskController->getTasks(2, $_GET['date'] ?? date('Y-m-d'));
             
        }
    }
   
}

$taskRouter = new TaskRouter();
$taskRouter->handleRequest();
?>