<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-Vindo ao Login - Sistemas de Gerenciamento de Entregas</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- CSS only -->
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <div id="form_screen">
        <div class="form_section">
            <header>
                <h4>Sistema de Gerenciamento de Entregas</h4>
            </header>
            <div class="form-controls">
                <div>
                    <h2>Login</h2>
                    <p>Bem-vindo ao Easy Delivery, coloque seus dados abaixo para começar a usar o
                        aplicativo</p>
                    <small id="error"><?=isset($_GET['error'])?'Usuário ou senha incorreto':'' ?> </small>
                    <form name="loginForm" onsubmit="return validationForm()" action="form_request/user_login.php"
                        method="POST">
                        <div class="input-group">
                            <label for="email">Email / Username</label>
                            <input type="text" name="username">
                        </div>
                        <div class="input-group">
                            <label for="password">Senha</label>
                            <input type="password" name="passwrd">
                        </div>
                        <div class="forget-pass">
                            <a href="forgetPassword.html">Esqueceu sua senha?</a>
                        </div>
                        <div class="remember_me">
                            <label for="checkbox">
                                <input type="checkbox" name="" id="checkbox">
                                Salvar login
                            </label>
                            <button class="btntheme" name="loginBtn">Entrar</button>
                        </div>
                    </form>
                    <div class="text-center">
                        Não possui uma conta? <a href="register.php">Registre-se</a>
                    </div>
                </div>

            </div>

            <footer>
                <p>&copy;2024. Feito com ❤️ por <a href="#">Maria Eduarda</a> </p>
            </footer>
        </div>
        <div class="ImageSection">
            <img src="./imagens/image.png" alt="">
        </div>
    </div>

</body>

</html>
<script>
function validationForm() {
    const username = document.loginForm.username.value.trim();
    const passwrd = document.loginForm.passwrd.value.trim();

    if (!username || !passwrd) {
        document.getElementById("error").innerHTML = "Por favor insira seu nome ou senha!";
        return false;
    }

    if (username.length < 4) {
        document.getElementById("error").innerHTML = "Username deve conter ao menos 4 letras";
        return false;
    }

    if (passwrd.length < 8) {
        document.getElementById("error").innerHTML = "A senha deve conter ao menos 8 caracteres!";
        return false;
    }

    return true;
}
</script>