<?php
require_once __DIR__ . '/../Controllers/taskController.php';
session_start(); 
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
                    $id = $_SESSION['user_id'];
                    if ($id && $description && $taskDate) {
                        $this->taskController->addTask($id, $taskDate, $description);
                        header("Location: ../../index.php?date=" . $taskDate);
                    } else {
                        echo json_encode(["error" => "Dados insuficientes para adicionar a tarefa"]);
                    }
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'complete':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskDate = $_POST['taskDate'] ?? date('Y-m-d');
                    $this->taskController->completedTask($taskDate);
                     header("Location: ../../index.php?date=" . $taskDate);
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'delete':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskDate = $_POST['taskDate'] ?? date('Y-m-d');
                    $this->taskController->deleteTask($taskDate);
                     header("Location: ../../index.php?date=" . $taskDate);
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $taskDate = $_POST['taskDate'] ?? date('Y-m-d');
                    $this->taskController->editTask($taskDate);
                     header("Location: ../../index.php?date=" . $taskDate);
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            default:
           $this->task = $this->taskController->getTasks($_SESSION['user_id'], $_GET['date'] ?? date('Y-m-d'));
             
        }
    }
   
}

$taskRouter = new TaskRouter();
$taskRouter->handleRequest();
?>