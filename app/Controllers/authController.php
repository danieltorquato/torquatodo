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
        $_SESSION['user_level'] = $user['level'];
        $_SESSION['user_mood'] = $user['mood'];
        setcookie($_SESSION['user_user'], $user['password'], time() + (86400 * 30), "/");
        header('Location: ../../index.php');
        exit();
    }else{
        echo "<script>alert('Usuário ou senha ou senha incorretos!'); window.location.href='../Views/login/login.php';</script>";
    }

   }

   public function logout(){
    session_destroy();
    header('Location: ../../index.php');
    exit();
   }
   public function register($name, $surname, $user,  $email, $password){
    $result = $this->userModel->registerUser($name, $surname, $user, $email, $password);


    if ($result === true) {
        echo "Cadastro realizado com sucesso!";
        header("Location: ../Views/login/login.php");
        exit();
    } else {
        echo $result; 
    }


   }

   public function updateMood($id, $mood){
    $result =   $this->userModel->updateMood($id,$mood);
    if ($result === true){
        echo 'Humor atualizado';
        header('Location: ../../index.php');
    }else {
        echo $result;
    }
   }
}
?>