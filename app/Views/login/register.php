<?php
// script para adicionar usuário
require_once __DIR__ . '/../..//Models/user.php';
require_once __DIR__ . '/../..//Config/db.php';


$userModel = new User();
$db = new Db;
$pdo = $db->getConnection();
$name = 'Exemplo';
$user = 'E.XAMPLE';
$email = 'usuario@exemplo.com';
$password = 'minhaSenha';

// Criptografa a senha
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insere no banco
$query = $pdo->prepare("INSERT INTO users (name ,email, password, user) VALUES (:name, :email, :password, :user)");
$query->bindParam(':name', $name);
$query->bindParam(':email', $email);
$query->bindParam(':password', $hashedPassword);
$query->bindParam(':user', $user);
$query->execute();
?>