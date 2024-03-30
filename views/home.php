<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/base.css" />
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home</title>
</head>

<body>
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="feed">
                <form id="postForm" method="post">
                    <textarea name="post_text" placeholder="Digite algo para publicar..." maxlength="200" required 
                        onblur="this.value=this.value.trim()"></textarea>
                    <button type="submit" class="button-lg button-information">
                        <i class="fa-solid fa-paper-plane"></i> Publicar                     
                    </button>
                </form>
                <div class="feed-publicacoes"></div>
            </div>
            <div class="lista">
                <div class="lista-amigos">

                </div>
                <button type="button" class="button-md button-information" onclick="window.location.href='friends.php'">
                    <i class="fa-solid fa-users"></i> Ver todos...
                </button>
            </div>
        </div>
        <?php require_once("footer.php"); ?>
    </div>

    <script src="../js/home.js"></script>   
    
</body>

</html>