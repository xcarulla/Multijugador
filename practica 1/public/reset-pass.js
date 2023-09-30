
// -------- Mail --------
const email = document.getElementById('email')

passwordCanviada = false

// -------- Comprovar formulari --------
form.addEventListener('submit', (e) => {
    e.preventDefault()

    changePassword()
        .then(result => {
            if(result) {
                passwordCanviada = true
            } else {
                passwordCanviada = false
            }
        })
        .catch(error => {
            console.error("Error:", error)
            alert("Error al canviar la contrassenya.")
        })

    if(passwordCanviada){
        var formAtributs = document.createElement('input')
        formAtributs.setAttribute('type','hidden')
        formAtributs.setAttribute('name','changepass')
        formAtributs.setAttribute('value','Canviar')
        form.appendChild(formAtributs)
        
        form.submit()
    }
})

// Comprovar base de dades

function changePassword() {
    const formData = new FormData();
    formData.append('password',password.value)
    formData.append('email',email.value)

    return new Promise((resolve,reject) => {
        fetch('canviarPasswordDB.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data === "ok") {
                resolve(true)
            } else resolve(false)
        })
        .catch(error => {
            console.error("Error en el fetch:", error);
            reject(error)
        })
    })
}
