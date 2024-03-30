<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/base.css" />
    <link rel="stylesheet" type="text/css" href="../css/search.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Pesquisa</title>
</head>

<body>
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="search">
                <form>
                    <input type="search" name="search" placeholder="Pesquisar" required 
                        onblur="this.value=this.value.trim()" />
                    <button type="submit" class="search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div class="lista"></div>
            </div>                       
        </div>        
        <?php require_once("footer.php"); ?>
    </div>

    <script src="../js/search.js"></script>

</body>

</html>