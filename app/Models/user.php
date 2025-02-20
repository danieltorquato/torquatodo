<?php
Class User{
    private $name;
    private $surname;
    private $email;
    private $password;
    private $level;
    private $pdo;
    public function __construct($email, $password, $name ='', $surname = '', $level = 'basic', $user = '' ){
        
        
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->level = $level;
        $this->user = $user;
   
    }
   
}

Class Login extends User{
    
    public function __construct($email, $password){
        parent::__construct($email, $password);
    }
}
?>