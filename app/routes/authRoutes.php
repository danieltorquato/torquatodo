<?php
require_once __DIR__ . '/../Controllers/authController.php';

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

            case 'register':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name']);
                    $surname = trim($_POST['surname']);
                    $user = trim($_POST['user']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    if (empty($name) && empty($surname) && empty($user) && empty($email) && empty($password)) {
                       echo "Todos os campos precisam ser preenchidos!";
                    }
                    else{
                        $this->authController->register($name, $surname, $user, $email, $password);
                    }
                } else {
                    $this->errorResponse("Método inválido!");
                }
                
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