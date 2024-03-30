<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/base.css" />
    <link rel="stylesheet" type="text/css" href="./css/forms.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
</head>

<body>
    
    <?php        
        if(!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = md5(time() . rand(0, 100000));
        }
    ?>

    <div class="container">        
        <form method="post">
            <legend>
                <span class="title">
                    <i class="fa-solid fa-globe"></i> Social Network
                </span>
            </legend>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="E-mail" required />
            <label for="userpassword">Senha</label>
            <input type="password" name="userpassword" placeholder="Senha" required />
            <button type="submit" class="button-lg button-success">
                <i class="fa-solid fa-check"></i> Login
            </button>
            <a href="register.php">Não tem conta? Registrar-se</a>
            <div class="alert alert-error" style="display: none;">
                <span class="message"></span>
                <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        </form>
    </div>
    
    <script src="./js/login.js"></script>

</body>

</html>