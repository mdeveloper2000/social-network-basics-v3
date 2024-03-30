<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/base.css" />
    <link rel="stylesheet" type="text/css" href="../css/messages.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Mensagens</title>
</head>

<body>
    <div class="container">
        <?php require_once("header.php"); ?>
        <div class="content">
            <?php require_once("menu.php"); ?>
            <div class="lista-mensagens">
                <div class="lista"></div>
                <div class="mensagens">
                    <div class="chat"></div>
                    <div class="form-chat">
                        <form>
                            <input type="hidden" id="to_id" name="to_id" />
                            <textarea name="message_text" maxlength="100" placeholder="Digite sua mensagem" required 
                            onblur="this.value = this.value.trim()"></textarea>
                            <button type="submit">
                                <i class="fa-solid fa-paper-plane"></i> Enviar Mensagem...
                            </button>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
        <?php require_once("footer.php"); ?>
    </div>

    <script src="../js/messages.js"></script>

</body>

</html>