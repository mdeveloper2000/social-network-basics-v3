const postForm = document.querySelector('#postForm')

postForm.addEventListener('submit', async (e) => {
        
    e.preventDefault()

    const post_text = postForm.post_text.value

    const formData = new FormData()
    formData.append("query", "save")
    formData.append("post_text", post_text)    
    
    try {
        await fetch('../controllers/PostController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data === null) {
                console.log('Erro ao tentar salvar publicação')             
            }
            else {
                const id = data
                const formDataPost = new FormData()
                formDataPost.append("query", "get")
                formDataPost.append("id", id) 
                fetch('../controllers/PostController.php', {
                    method: 'POST',
                    body: formDataPost,
                    headers: {
                        'Accept': 'application/json, text/plain, */*'                
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data === null) {
                        console.log('Erro ao tentar recuperar publicação')
                    }
                    else {
                        postForm.reset()
                        addPost(data)
                    }
                })
            }            
        })
    } 
    catch(error) {
        console.log(error)
    }

})

function addPost(post) {
    const feed_publicacoes = document.querySelector('.feed-publicacoes')
    const container = document.createElement("div")
    const divComment = document.createElement("div")
    const divIcons = document.createElement("div")
    const divComments = document.createElement("div")
    const divTextArea = document.createElement("div")
    divComment.classList.add('publicacoes')
    divComments.classList.add("list-comments")
    divComments.classList.add((post.post !== undefined ? "class" + post.post.id : "class" + post.id))
    divIcons.classList.add("div-icons")
    const img = document.createElement("img")
    img.classList.add("avatar")
    img.src = "../pictures/" + (post.post !== undefined ? post.post.picture : post.picture)
    const data_publicacao = document.createElement('span')
    data_publicacao.classList.add('data-publicacao')    
    data_publicacao.innerHTML = (post.post !== undefined ? post.post.username + " - " + post.post.post_date : post.username + " - " + post.post_date)  
    const texto = document.createElement("div")
    texto.innerHTML = (post.post !== undefined ? post.post.post_text : post.post_text)
    texto.style.marginTop = "5px";
    let postID = post.post !== undefined ? post.post.id : post.id
    let liked = post.post !== undefined ? post.post.liked : post.liked
    const iconLikes = document.createElement("i")   
    iconLikes.classList.add("fa-regular", "fa-heart", "like" + postID)
    if(liked !== null) {
        iconLikes.classList.remove("fa-regular")
        iconLikes.classList.add("fa-solid", "liked") 
    }
    const likesText = document.createElement("span")
    iconLikes.onclick = () => {
        giveLike(postID, "like" + postID, likesText)
    }
    
    likesText.style.marginLeft = "10px"
    likesText.style.marginRight = "50px"
    likesText.innerHTML = (post.post !== undefined ? post.post.likes_quantity : post.likes_quantity)
    const iconComments = document.createElement("i")
    iconComments.classList.add("fa-regular", "fa-comments")
    const commentsText = document.createElement("span")
    commentsText.style.marginLeft = "10px"
    commentsText.innerHTML = (post.post !== undefined ? post.post.comments_quantity : post.comments_quantity)
    const commentTextArea = document.createElement("textarea")    
    commentTextArea.id = (post.post !== undefined ? "post" + post.post.id : "post" + post.id)
    commentTextArea.placeholder = "Digite seu comentário e pressione ENTER para enviar"    
    commentTextArea.onkeydown = (e) => {
        sendComment(e, commentTextArea.id, postID, commentsText)
    }
    divComment.appendChild(img)
    divComment.appendChild(data_publicacao)
    divComment.appendChild(texto)
    divIcons.appendChild(iconLikes)
    divIcons.appendChild(likesText)
    divIcons.appendChild(iconComments)
    divIcons.appendChild(commentsText)
    if(post.comments !== undefined && post.comments !== null) {
        post.comments.forEach((comment) => {
            const div = document.createElement("div")        
            const name = document.createElement("div")
            const picture = document.createElement("img")
            const text = document.createElement("div")
            picture.classList.add("avatar")
            picture.src = "../pictures/" + comment.picture
            name.innerHTML = comment.username
            text.innerHTML = comment.comment_text
            div.append(picture)
            div.append(name)
            div.append(text)
            divComments.prepend(div)
        })
    }
        
    divTextArea.appendChild(commentTextArea)
    container.appendChild(divComment)
    container.appendChild(divIcons)
    container.appendChild(divComments)
    container.appendChild(divTextArea)
    feed_publicacoes.prepend(container)
    
}

window.onload = async () => {
    
    const formData = new FormData()
    formData.append("query", "list")       
    
    try {
        await fetch('../controllers/PostController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data === null) {
                console.log('Erro ao listar publicações ou não há publicações')
            }            
            else {                
                data.forEach(publicacao => {
                    addPost(publicacao)                   
                })
            }            
        })
    } 
    catch(error) {
        console.log(error)
    }

    try {
        const formData = new FormData()
        formData.append("query", "listHomePage") 
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
                console.log('Lista retornou sem resultados')
            }            
            else {
                const lista_amigos = document.querySelector(".lista-amigos")                
                data.forEach(usuario => {
                    const div = document.createElement("div")
                    div.classList.add("amizade")
                    const img = document.createElement("img")
                    img.src = "../pictures/" + usuario.picture
                    div.appendChild(img)
                    const span = document.createElement("span")
                    span.innerHTML = usuario.username
                    div.appendChild(span)
                    lista_amigos.appendChild(div)
                })
            }            
        })
    } 
    catch(error) {
        console.log(error)
    }

}

async function sendComment(event, id, post_id, commentsText) {
    if(event.keyCode === 13) {
        const text = document.getElementById(id).value
        if(text.trim() !== "") {
            try {
                const formData = new FormData()
                formData.append("query", "comment")
                formData.append("comment_text", text)
                formData.append("post_id", post_id)
                await fetch('../controllers/PostController.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {            
                    if(data === null) {
                        console.log('Erro ao salvar comentário')
                    }            
                    else {
                        document.getElementById(id).value = ""
                        let comments = parseInt(commentsText.innerHTML)
                        comments++
                        commentsText.innerHTML = comments
                        addComment(data, "class" + post_id)
                    }            
                })
            } 
            catch(error) {
                console.log(error)
            }           
        }
    }
}

function addComment(comment, listClass) {
    const list = document.querySelector('.'+listClass)
    const div = document.createElement("div")        
    const name = document.createElement("div")
    const picture = document.createElement("img")
    const text = document.createElement("div")
    picture.classList.add("avatar")
    picture.src = document.querySelector('.avatar').src
    name.innerHTML = document.querySelector('.username-span').innerHTML
    text.innerHTML = comment.comment_text
    div.append(picture)
    div.append(name)
    div.append(text)
    list.prepend(div)
}

async function giveLike(postID, likeClass, likeText) {
    const formData = new FormData()
    formData.append("query", "like")       
    formData.append("post_id", postID)
    try {
        await fetch('../controllers/PostController.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json, text/plain, */*'                
            }
        })
        .then((res) => res.json())
        .then((data) => {            
            if(data === null) {
                console.log('Erro ao dar like na publicação')             
            }            
            else if(data === true) {       
                const like = document.querySelector('.'+likeClass)
                let likes = parseInt(likeText.innerHTML)
                likes++                
                likeText.innerHTML = likes
                like.classList.remove("fa-regular")
                like.classList.add("fa-solid", "liked")                
            }
            else {
                const like = document.querySelector('.'+likeClass)
                let likes = parseInt(likeText.innerHTML)
                likes--
                likeText.innerHTML = likes
                like.classList.remove("fa-solid", "liked")
                like.classList.add("fa-regular")
            }            
        })
    } 
    catch(error) {
        console.log(error)
    }
}