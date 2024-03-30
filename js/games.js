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
games.addEventListener('change', () => {
    if(games.value !== "") {
        window.location.href = "game0" + games.value + ".php" 
    }
})