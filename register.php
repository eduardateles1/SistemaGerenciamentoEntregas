<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- CSS only -->
    <link rel="stylesheet" href="./css/styles.css">
    <!-- JavaScript -->
</head>

<body>
    <div id="form_screen">
        <div class="form_section">
            <header>
                <h4>Torne-se membro e aproveite promoções exclusivas</h4>
            </header>
            <div class="form-controls">
                <div>
                    <h2>Registre-se</h2>
                    <p>Tenha acesso à promoções exclusivas criando sua conta agora!</p>
                    <div class="alert">
                        <?php
                            if(isset($_SESSION['status'])){
                                echo "<h4>" .$_SESSION['status']. "</h4>";
                                unset($_SESSION['status']);
                            }
                        ?>
                    </div>
                    <small
                        id="error"><?php echo isset($_GET['error']) ? $_GET['error'] . " O nome de usuário já existe" : ' '; ?></small>
                    <form action="form_request/user_register.php" name="registerForm" onsubmit="return 
                    validationForm()" method="POST">
                         <div class="input-group">
                            <label for="email">Username</label>
                            <input type="text" name="username">
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="text" name="email">
                        </div>
                        <div class="input-group">
                            <label for="password">Senha</label>
                            <input type="password" name="passwrd"  autocomplete="off">
                        </div>
                        <div class="remember_me text-end">
                            <button class="btntheme" name="registerBTn">Cadastre-se</button>
                        </div>
                        <br>
                    </form>
                    <div class="text-center">
                        Já possui uma conta? <a href="index.php">Fazer login</a>
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

    if (document.registerForm.username.value.length < 1 && document.registerForm.email.value.length <
        1 && document.registerForm.passwrd.value.length < 1) {
        document.getElementById("error").innerHTML = "Por favor insira seus dados!";
        return false;
    } else {
        if (document.registerForm.username.value.length < 4) {
            document.getElementById("error").innerHTML = "Username deve conter ao menos 4 letras";
            return false;
        }
        if (document.registerForm.email.value.length < 10) {
            document.getElementById("error").innerHTML = "Email inválido!";
            return false;
        }
        if (document.registerForm.passwrd.value.length < 8) {
            document.getElementById("error").innerHTML = "A senha deve conter ao menos 8 caracteres!";
            return false;
        }
        return true;
    }
}
</script>