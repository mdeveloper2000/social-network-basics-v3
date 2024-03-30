const form = document.querySelector('form')

form.addEventListener('submit', async (e) => {
        
    e.preventDefault()

    const email = form.email.value
    const userpassword = form.userpassword.value
    const csrf_token = form.csrf_token.value

    const formData = new FormData()
    formData.append("query", "login")
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
            if(data === null) {
                const alert_div = document.querySelector('.alert')
                const message = document.querySelector('.message')
                message.innerHTML = "E-mail e/ou senha incorretos"
                alert_div.style.display = "block"
            }
            else {
                window.location.href = "../views/home.php"
            }
        })
    } 
    catch(error) {
        console.log(error)
    }

})