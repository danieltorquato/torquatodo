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
}
?>