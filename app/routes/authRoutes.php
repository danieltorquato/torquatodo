<?php
require_once __DIR__ . '/../Controllers/AuthController.php';

Class AuthRouter{    
    
    private $authController;

    public function __construct(){
        $this->authController = new AuthController();

    }
    public function handleRequest() {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'login':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->authController->login($_POST['user'], $_POST['password']);
                } else {
                    $this->errorResponse("Método inválido!");
                }
                break;

            case 'logout':
                $this->authController->logout();
                break;

            default:
                $this->errorResponse("Ação inválida!");
        }
    }

    private function errorResponse($message) {
        echo json_encode(["error" => $message]);
        http_response_code(400);
        exit();
    }
}

// Executa o roteador
$router = new AuthRouter();
$router->handleRequest();

?>