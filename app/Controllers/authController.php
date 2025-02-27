<?php
require_once __DIR__ . '/../Models/user.php';
session_start();
class AuthController{
    private $userModel;

    public function __construct(){
        $this->userModel = new User();

    }
   public function login($user, $password){
    $user = $this->userModel->getUser($user);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_user'] = $user['user'];
        $_SESSION['user_firstname'] = $user['first_name'];
        $_SESSION['user_img'] = $user['img'];
        header('Location: ../../index.php');
        exit();
    }else{
        echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='../Views/login/login.php';</script>";
    }

   }

   public function logout(){
    session_destroy();
    header('Location: ../../index.php');
    exit();
   }
}
?>