window.onload = async () => {
    const formData = new FormData()
    formData.append("query", "list")
    try {
        await fetch('../controllers/MessageController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {
            if(data === null) {
                console.log("Erro ao recuperar lista de mensagens")
            }
            else {
                const lista = document.querySelector(".lista")
                data.forEach(usuario => {
                    const div = document.createElement("div")
                    const divId = 'id' + usuario.id
                    div.id = divId
                    div.classList.add("lista-usuario")
                    const img = document.createElement("img")
                    img.classList.add("foto")
                    img.src = "../pictures/" + usuario.picture
                    div.appendChild(img)
                    const span = document.createElement("span")
                    span.classList.add("nome")
                    span.innerHTML = usuario.username
                    div.appendChild(span)
                    lista.appendChild(div)
                    div.onclick = () => {
                        selecinarConversa(div.id, img.src)
                    }
                })
            }
        })
    } 
    catch(error) {
        console.log(error)
    }
}

async function selecinarConversa(id, imgSrc) {
    const listas = document.querySelectorAll(".lista-selected")
    listas.forEach(lista => {
        lista.classList.remove("lista-selected")
    })
    document.querySelector(`#${id}`).classList.add("lista-selected")
    const lista_mensagens = document.querySelector(".lista-mensagens")
    lista_mensagens.setAttribute("usuario_id", id.substring(2))
    const formData = new FormData()
    formData.append("query", "get")
    const usuario_id = lista_mensagens.getAttribute("usuario_id")
    formData.append("id", usuario_id)
    const to_id = document.querySelector("#to_id")
    to_id.value = usuario_id
    
    try {
        await fetch('../controllers/MessageController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {
            if(data !== null) {
                const formChat = document.querySelector(".form-chat")
                formChat.style.display = "block"
                const chat = document.querySelector(".chat")
                chat.innerHTML = ""
                data.forEach(mensagem => {
                    const div = document.createElement("div")
                    const img = document.createElement("img")
                    const span = document.createElement("span")
                    img.classList.add("chat-img")
                    span.innerHTML = mensagem.message_text                    
                    if(mensagem.to_id == usuario_id) {
                        div.classList.add("banner-message", "banner-sender")
                        img.src = document.querySelector(".avatar").src                        
                    }
                    else {
                        div.classList.add("banner-message", "banner-receiver")
                        img.src = imgSrc
                    }                    
                    div.appendChild(img)
                    div.appendChild(span)
                    chat.appendChild(div)
                })
            }
            else {
                console.log("Erro ao selecionar conversa")
            }
        })
    } 
    catch(error) {
        console.log(error)
    }

}

const form = document.querySelector('form')

form.addEventListener('submit', async (e) => {        
    e.preventDefault()    
    const to_id = document.querySelector("#to_id").value
    const message_text = form.message_text.value
    const formData = new FormData()
    formData.append("query", "save")
    formData.append("to_id", to_id)
    formData.append("message_text", message_text)
    try {
        await fetch('../controllers/MessageController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'
            }
        })
        .then((res) => res.json())
        .then((data) => {
            if(data !== null) {
                const chat = document.querySelector(".chat")                
                const div = document.createElement("div")
                const img = document.createElement("img")
                const span = document.createElement("span")
                img.classList.add("chat-img")
                span.innerHTML = data.message_text
                div.classList.add("banner-message", "banner-sender")
                img.src = document.querySelector(".avatar").src
                div.appendChild(img)
                div.appendChild(span)
                chat.prepend(div)
                form.message_text.value = ""
            }
            else {
                console.log('Erro ao enviar mensagem')
            }
        })
    } 
    catch(error) {
        console.log(error)
    }

})