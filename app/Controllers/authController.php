<?php
require_once __DIR__ . '/../Config/db.php';
require_once __DIR__ . '/../Models/user.php';
class AuthController{
    private $pdo;

    public function __construct(){
        $db = new Db();
        $this->pdo = $db->getConnection();
    }
    public function getUserByEmail($email) {
        try {
            $query = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $query->execute([$email]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
           echo 'Erro ao capturar usuário: ' . $e->getMessage();
       
        }
    }
}
?>