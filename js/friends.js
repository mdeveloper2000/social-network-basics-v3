const form = document.querySelector("form")

form.addEventListener('submit', async (e) => {    
    e.preventDefault()    
    const message_text = form.message_text.value
    const to_id = form.to_id.value
    const formData = new FormData()
    formData.append("query", "save")
    formData.append("message_text", message_text)
    formData.append("to_id", to_id)
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
                form.message_text.value = ""
            }
            else {
                console.log("Erro ao enviar mensagem")
            }
        })
    } 
    catch(error) {
        console.log(error)
    }
})

window.onload = async () => {
    
    const formData = new FormData()
    formData.append("query", "list")    
    
    try {
        await fetch('../controllers/InvitationController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data === null) {
                console.log('Erro ao tentar pesquisar amizades')             
            }
            else {                
                const enviadasDiv = document.querySelector("#enviadas")
                data.invites_sent.forEach(usuario => {
                    const div = document.createElement('div')
                    const span = document.createElement('span')
                    const img = document.createElement('img')
                    const button = document.createElement('button')
                    div.classList.add("banner")
                    const bannerClass = "bannerClass" + usuario.id
                    div.classList.add(bannerClass)
                    span.innerHTML = usuario.username
                    div.appendChild(span)
                    img.classList.add("foto")
                    img.src = "../pictures/" + usuario.picture
                    div.appendChild(img)
                    button.classList.add('button-cancel')
                    button.innerHTML = '<i class="fa-solid fa-ban"></i> Cancelar convite...'
                    button.onclick = () => {
                        cancelarConvite(bannerClass, usuario.id)
                    }
                    div.appendChild(button)
                    enviadasDiv.appendChild(div)
                })
                const recebidasDiv = document.querySelector("#recebidas")
                data.invites_received.forEach(usuario => {
                    const div = document.createElement('div')
                    const span = document.createElement('span')
                    const img = document.createElement('img')
                    const button = document.createElement('button')
                    div.classList.add("banner")
                    const bannerClass = "bannerClass" + usuario.id
                    div.classList.add(bannerClass)
                    span.innerHTML = usuario.username
                    div.appendChild(span)
                    img.classList.add("foto")
                    img.src = "../pictures/" + usuario.picture
                    div.appendChild(img)
                    button.classList.add('button-accept')
                    button.innerHTML = '<i class="fa-solid fa-handshake"></i> Aceitar convite'
                    button.onclick = () => {
                        aceitarConvite(bannerClass, usuario.id)
                    }
                    div.appendChild(button)
                    recebidasDiv.appendChild(div)
                })
            }            
        })
    } 
    catch(error) {
        console.log(error)
    }

    try {
        const formData = new FormData()
        formData.append("query", "list")
        await fetch('../controllers/FriendshipController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data === null) {
                console.log('Erro ao tentar pesquisar amizades')             
            }
            else {
                const amizadesDiv = document.querySelector("#amizades")
                data.forEach(usuario => {
                    const div = document.createElement('div')
                    const span = document.createElement('span')
                    const img = document.createElement('img')
                    const button = document.createElement('button')
                    div.classList.add("banner")
                    span.innerHTML = usuario.username
                    div.appendChild(span)
                    img.classList.add("foto")
                    img.src = "../pictures/" + usuario.picture
                    div.appendChild(img)
                    button.classList.add("button-md", "button-information")
                    button.innerHTML = '<i class="fa-solid fa-envelope"></i> Enviar Mensagem...'
                    button.onclick = () => {
                        selecionarModal(usuario.id)
                    }
                    div.appendChild(button)
                    amizadesDiv.appendChild(div)
                })
            }
        })
    }
    catch(error) {
        console.log(error)
    }

}

async function aceitarConvite(bannerClass, id) {
    const formData = new FormData()
    formData.append("query", "accept")
    formData.append("id", id)
    try {
        await fetch('../controllers/InvitationController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {
            if(data === true) {
                const banner = document.querySelector('.'+bannerClass)
                banner.style.display = 'none'
            }
            else {
                console.log("Erro ao aceitar convite")
            }
        })
    } 
    catch(error) {
        console.log(error)
    }
}

async function cancelarConvite(bannerClass, id) {
    const formData = new FormData()
    formData.append("query", "cancel")
    formData.append("id", id)
    try {
        await fetch('../controllers/InvitationController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {
            if(data === true) {
                const banner = document.querySelector('.'+bannerClass)
                banner.style.display = 'none'
            }
            else {
                console.log("Erro ao cancelar convite")
            }
        })
    } 
    catch(error) {
        console.log(error)
    }
}

async function selecionarModal(id) {
    const modal = document.querySelector("#myModal");
    const to_id = document.querySelector("#to_id")
    to_id.value = id
    modal.style.display = "block";
    document.querySelector("textarea").focus()        
    const btn = document.querySelector("#myBtn");
    const span = document.querySelector(".close");
    span.onclick = () => {
        modal.style.display = "none"
    }
    window.onclick = (event) => {
        if(event.target === modal) {
            modal.style.display = "none"
        }
    }
}

function openTab(event, tabName) {
    let tabcontent, tablinks            
    tabcontent = document.querySelectorAll(".tabcontent")
    for(let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"
    }            
    tablinks = document.querySelectorAll(".tablinks")
    for(let i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace("active", "")
    }            
    document.querySelector(`#${tabName}`).style.display = "block"
    event.currentTarget.className += " active"
}
    
document.querySelector('#defaultTab').click()