<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="register-container">
            <h2>Crie sua conta!</h2>
            <form action="../../routes/authRoutes.php?action=register" method="post">
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="surname">Sobrenome:</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
                <div class="form-group">
                    <label for="user">Usuário:</label>
                    <input type="text" class="form-control" id="user" name="user" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirme a Senha:</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                </div>
                <p id="error-message" class="text-danger" style="display: none;">As senhas não coincidem.</p>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
            <div class="footer">
                <p>Já tem uma conta? <a href="../login/login.php">Faça login</a></p>
            </div>
        </div>
    </div>
</body>
<script>
 function validarSenha() {
        var senha = document.getElementById("password").value;
        var confirmarSenha = document.getElementById("confirm-password").value;
        var errorMessage = document.getElementById("error-message");

        if (senha !== confirmarSenha) {
            errorMessage.style.display = "block";
            return false;
        } else {
            errorMessage.style.display = "none";
            return true;
        }
    }
</script>
</html>