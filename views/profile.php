<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <link rel="stylesheet" type="text/css" href="../css/profile.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Perfil</title>
</head>

<body>
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="perfil perfil-edit">
                <input type="hidden" id="id" value="<?= $_SESSION["id"] ?>" />                
                <img class="fotoAtualizada" src="../pictures/<?= $_SESSION['picture'] ?>" width="250" height="250" />
                <span id="about" name="about"></span>
                <ul>
                    <li>
                        <i class="fa-solid fa-cake-candles"></i> <span id="birthday"></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-location-dot"></i> <span id="born_in"></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-briefcase"></i> <span id="profession"></span>
                    </li>
                </ul>
            </div>
        </div>
        <?php require_once("footer.php"); ?>
    </div>

    <script src="../js/profile.js"></script>
    
</body>

</html>