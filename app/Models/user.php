<?php
require_once __DIR__ . '/../Config/db.php';
Class User{
   private $pdo;
   private $table = 'users';

   public function __construct(){
    $db = new Db();
    $this->pdo = $db->getConnection();
   }
   public function getUser($user){
    $query = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE user= ?");
    $query->execute([$user]);
    return $query->fetch(PDO::FETCH_ASSOC);
}
public function registerUser($name, $surname, $user, $email, $password){
   
    $query = $this->pdo->prepare("SELECT * FROM users WHERE user = ?");
    $query->execute([
        $user
    ]);
    if ($query->fetch()) {
        return "Nome de usuário já cadastrado!";
    }
    $query = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([
        $email
    ]);
    if ($query->fetch()) {
        return "E-mail já cadastrado!";
    }
     $cryptPassword = password_hash($password, PASSWORD_BCRYPT);

     $query = $this->pdo->prepare("INSERT INTO users (name, surname, user, email, password) VALUES(?,?,?,?,?)");
     if($query->execute([
        $name,
        $surname,
        $user,
        $email,
        $cryptPassword
     ])){
        return true;
     }else{
        echo "Não cadastrado";
     }
     
}
}
?>