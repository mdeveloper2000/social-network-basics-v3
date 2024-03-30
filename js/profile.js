window.onload = async () => {
    const formData = new FormData()
    const about = document.querySelector('#about')
    const birthday = document.querySelector('#birthday')
    const born_in = document.querySelector('#born_in')
    const profession = document.querySelector('#profession')
    formData.append("query", "get")
    await fetch('../controllers/ProfileController.php', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json, text/plain, */*'
        }
    })
    .then((res) => res.json())
    .then((data) => {            
        if(data !== null) {
            const id = data.id            
            if(id === parseInt(document.querySelector("#id").value)) {
                const perfil = document.querySelector(".perfil")
                const button = document.createElement("button")
                button.innerHTML = '<i class="fa-solid fa-user-pen"></i> Editar perfil'
                button.onclick = () => {
                    loadProfile(id)
                }
                button.classList.add("button-md", "button-information")
                perfil.prepend(button)
            }
            about.innerHTML = data.about
            const dia = data.birthday.substring(0, 2) 
            const mes = data.birthday.substring(2)
            birthday.innerHTML = (dia !== '' ? dia : '?') + '/' + (mes !== '' ? mes : '?')
            born_in.innerHTML = data.born_in
            profession.innerHTML = data.profession
        }
        else {
            console.log('Erro ao tentar recuperar perfil')            
        }            
    })
}

function loadProfile(id) {
    if(id === parseInt(document.querySelector("#id").value)) {
        window.location.href = "editprofile.php"
    }
}