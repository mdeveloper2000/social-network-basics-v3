window.onload = async () => {
    const formData = new FormData()    
    formData.append("query", "list")
    await fetch('../controllers/GameController.php', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json, text/plain, */*'                
        }
    })
    .then((res) => res.json())
    .then((data) => {            
        if(data !== null) {
            const selectGames = document.querySelector("#games")
            data.forEach(game => {
                const option = document.createElement("option")
                option.value = game.id
                option.innerHTML = game.gamename
                selectGames.appendChild(option)    
            })
        }
        else {
            console.log('Erro ao listar games, ou não há games')
        }
    })
}

const games = document.querySelector("#games")
games.addEventListener('change', async () => {
    if(games.value !== "") {
        const formData = new FormData()    
        formData.append("query", "list")
        formData.append("game_id", games.value)
        await fetch('../controllers/RecordController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data !== null) {
                const listRecords = document.querySelector(".list")
                listRecords.innerHTML = ""
                const ul = document.createElement("ul")
                data.forEach((record, index) => {
                    const li = document.createElement("li")
                    const span = document.createElement("span")
                    const icon = document.createElement("i")
                    if(index === 2) {
                        icon.style.fontSize = "22px"
                        icon.style.color = "#cd7f32"                   
                    }
                    if(index === 1) {
                        icon.style.fontSize = "26px"
                        icon.style.color = "#C0C0C0"
                    }
                    if(index === 0) {
                        icon.style.fontSize = "30px"
                        icon.style.color = "#FFD700"
                    }
                    else if(index > 2) {
                        icon.style.color = "#0000CD"
                    }
                    icon.innerHTML = '<i class="fa-solid fa-trophy"></i>' 
                    span.innerHTML = " " + record.score + ' - ' + record.username
                    const position = document.createElement("span")
                    position.innerHTML = index + 1
                    position.style.float = "right"
                    li.appendChild(icon)
                    li.appendChild(span)
                    li.appendChild(position) 
                    ul.appendChild(li)
                    const id = parseInt(document.querySelector('#id').value)
                    if(record.user_id === id) {
                        li.style.background = "#00FA9A"
                    }
                })
                listRecords.appendChild(ul)
            }
            else {
                console.log('Erro ao listar recordes, ou não há recordes')
            }
        })
    }
})