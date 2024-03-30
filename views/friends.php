<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/base.css" />
    <link rel="stylesheet" type="text/css" href="../css/friends.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Amigos</title>
</head>

<body>
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="lista">
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'amizades')" id="defaultTab">
                        <i class="fa-solid fa-users"></i> Amigos
                    </button>
                    <button class="tablinks" onclick="openTab(event, 'enviadas')">
                        <i class="fa-solid fa-arrow-right"></i> Solicitações Enviadas
                    </button>
                    <button class="tablinks" onclick="openTab(event, 'recebidas')">
                        <i class="fa-solid fa-arrow-left"></i> Solicitações Recebidas
                    </button>
                </div>
                <div id="amizades" class="tabcontent"></div>
                <div id="enviadas" class="tabcontent"></div>
                <div id="recebidas" class="tabcontent"></div>
            </div>
        </div>
        
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form class="modal-form">
                    <input type="hidden" id="to_id" />
                    <textarea name="message_text" placeholder="Digite a mensagem" maxlength="150" required
                        onblur="this.value=this.value.trim()"></textarea>
                        <button class="button-md button-information" type="submit">
                            <i class="fa-solid fa-paper-plane"></i> Enviar
                        </button>
                </form>                
            </div>
        </div> 
        
        <?php require_once("footer.php"); ?>

    </div>

    <script src="../js/friends.js"></script>

</body>

</html>