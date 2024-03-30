<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <link rel="stylesheet" type="text/css" href="../css/editprofile.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Editar Perfil</title>
</head>

<body>    
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="perfil">
                <input type="hidden" id="id" value="<?= $_SESSION['id'] ?>" />
                <img class="fotoAtualizada" src="../pictures/<?= $_SESSION['picture'] ?>" width="250" height="250" />
                <form id="updatePicture" method="post" enctype="multipart/form-data">
                    <input type="file" id="picture" name="picture" class="foto" style="position: absolute; margin-left: -2000px;" />
                    <button type="button" class="button-md button-success" onclick="selecionarFoto()">
                        <i class="fa-solid fa-image"></i> Selecionar Foto
                    </button>
                    <button type="submit" class="button-md button-information">
                        <i class="fa-solid fa-camera"></i> Atualizar Foto
                    </button>
                </form>
                <form id="updateProfile">                    
                    <textarea id="about" name="about" maxlength="150" placeholder="Fale um pouco sobre você..."></textarea>
                    <div>
                    <select id="day">
                        <option value=""></option>                        
                    </select>
                    <select id="month">
                        <option value=""></option>                        
                    </select>
                    <input type="text" id="born_in" maxlength="30" placeholder="Nascido em (cidade, país)" />
                    <input type="text" id="profession" maxlength="30" placeholder="Profissão" />
                </div>                    
                    <button type="submit" class="button-md button-information">
                        <i class="fa-solid fa-square-pen"></i> Atualizar Perfil
                    </button>
                </form>
            </div>
        </div>
        <?php require_once("footer.php"); ?>
    </div>

    <script src="../js/edit.js"></script>
    
</body>

</html>