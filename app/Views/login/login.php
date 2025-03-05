<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h2>Bem-vindo(a) de volta!</h2>
            <form action="../../routes/authRoutes.php?action=login" method="post">
                <div class="form-group">
                    <label for="user">Usuário: </label>
                    <input type="text" class="form-control" id="user" name="user" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <div class="footer">
                <p>Não tem uma conta? <a href="../register/register.php">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</body>
<script>

</script>
</html>
i