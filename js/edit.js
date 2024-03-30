const pictureForm = document.querySelector('#updatePicture')
const perfilForm = document.querySelector('#updateProfile')

pictureForm.addEventListener('submit', async (e) => {
        
    e.preventDefault()

    const formData = new FormData()
    const file = document.querySelector("#picture")
    formData.append("query", "updatePicture")
    formData.append("picture", file.files[0])

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
            const fotoAtualizada = document.querySelector('.fotoAtualizada')
            fotoAtualizada.src = "../pictures/" + data
        }
        else {
            console.log('Erro ao tentar salvar publicação')
        }            
    })

})

perfilForm.addEventListener('submit', async (e) => {
        
    e.preventDefault()

    const formData = new FormData()
    const about = perfilForm.about.value
    const day = perfilForm.day.value
    const month = perfilForm.month.value 
    const born_in = perfilForm.born_in.value
    const profession = perfilForm.profession.value
    formData.append("query", "update")
    formData.append("about", about)
    formData.append("day", day)
    formData.append("month", month)
    formData.append("born_in", born_in)
    formData.append("profession", profession)
    if((day === "" && month === "") || (day !== "" && month !== "")) {
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
                window.location.href = "profile.php"
            }
            else {
                console.log('Erro ao tentar atualizar perfil')            
            }
        })
    }
    else {
        console.log('A data está incompleta, dia e mês devem ser informados')
    }
    

})

function selecionarFoto() {
    const btn = document.querySelector('.foto')
    btn.click()
}

window.onload = async () => {
    const formData = new FormData()
    const about = document.querySelector("#about")
    const day = document.querySelector("#day")
    const month = document.querySelector("#month")
    const born_in = document.querySelector("#born_in")

    for(let i = 1; i < 32; i++) {
        let option = document.createElement("option")
        let optionText = document.createTextNode(i < 10 ? "0" + i : i)
        option.appendChild(optionText)
        option.setAttribute("value", i < 10 ? "0" + i : i)
        day.appendChild(option)
    }
    
    for(let i = 1; i < 13; i++) {
        let option = document.createElement("option")
        let optionText = document.createTextNode(i < 10 ? "0" + i : i)
        option.appendChild(optionText)
        option.setAttribute("value", i < 10 ? "0" + i : i)
        month.appendChild(option)
    }

    const profession = document.querySelector("#profession")
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
                about.innerHTML = data.about
                day.value = data.birthday.substring(0, 2)
                month.value = data.birthday.substring(2)
                born_in.value = data.born_in
                profession.value = data.profession
            }
        }
        else {
            console.log('Erro ao tentar recuperar perfil')
        }            
    })
}