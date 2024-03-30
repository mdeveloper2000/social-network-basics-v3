const form = document.querySelector('form')

form.addEventListener('submit', async (e) => {
        
    e.preventDefault()

    const username = form.username.value
    const email = form.email.value
    const userpassword = form.userpassword.value
    const csrf_token = form.csrf_token.value

    const formData = new FormData()
    formData.append("query", "register")
    formData.append("username", username)
    formData.append("email", email)
    formData.append("userpassword", userpassword)
    formData.append("csrf_token", csrf_token)
    
    try {
        await fetch('./controllers/UserController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {
            const alert_div = document.querySelector('.alert')
            const message = document.querySelector('.message')
            if(data === null) {
                alert_div.classList.remove('alert-success')
                alert_div.classList.add('alert-error')
                message.innerHTML = "Erro ao fazer registro"                
            }
            else if(data === false) {
                alert_div.classList.remove('alert-success')
                alert_div.classList.add('alert-error')
                message.innerHTML = "E-mail já registrado"                
            }
            else if(data === true) {                
                alert_div.classList.remove('alert-error')
                alert_div.classList.add('alert-success')
                message.innerHTML = "Registro realizado com sucesso"
                form.reset()
            }
            alert_div.style.display = "block"
        })
    } 
    catch(error) {
        console.log(error)
    }

})