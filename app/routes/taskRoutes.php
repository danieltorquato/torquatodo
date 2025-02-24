<?php
require_once __DIR__ . '/../Controllers/taskController.php';

class TaskRouter {
    private $taskController;

    public $data;
    public function __construct() {
       
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'read': // Ler as tarefas
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    
                    $input = file_get_contents("php://input");
                    $this->data = json_decode($input, true);
                    header("Location: ../../index.php");
                   
                } else {
                    echo json_encode(["error" => "Método não permitido"]);
                }
                break;
            case 'add': // Adicionar uma nova tarefa
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->taskController->addTask();
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
                echo json_encode(["error" => "Ação inválida"]);
        }
    }

       
        public function getTaskDate() {
        return $this->data;
    }
}

?>