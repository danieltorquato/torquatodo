<?php
require_once __DIR__ . '/../Controllers/TaskController.php';

$task = new TaskController();

$action = $_GET['action'] ?? null;

switch ($action) {
    
    case 'add': // Adicionar uma nova tarefa
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->addTask();
        } else {
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case 'complete': // Marcar tarefa como concluída
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->completedTask();
        } else {
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;
    case 'delete': // Marcar tarefa como concluída
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->deleteTask();
        } else {
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    default:
        echo json_encode(["error" => "Ação inválida"]);
}
?>