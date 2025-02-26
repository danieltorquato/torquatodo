<?php
require_once __DIR__ . '/../Controllers/taskController.php';

class TaskRouter {
    private $taskController;

    public function __construct() {
        $this->taskController = new TaskController();

        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'add': // Adicionar uma nova tarefa
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $description = $_POST['description'] ?? null;
                    $taskDate = $_POST['taskDate'] ?? date('Y-m-d'); // Capturando a data
                                    $this->taskController->addTask($taskDate, $description);
                    if ($description && $taskDate) {
                        $taskController->addTask($taskDate, $description);
                    } else {
                        echo json_encode(["error" => "Dados insuficientes para adicionar a tarefa"]);
                    }
                  
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            case 'complete': // Marcar tarefa como concluída
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->completedTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            case 'delete': // Deletar tarefa
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->deleteTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            case 'update': // Atualizar tarefa
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->editTask();
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            default:
                return;
        }
    }
}
$taskRouter = new TaskRouter();
?>