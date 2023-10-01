const form = document.getElementById('form')

// -------- Usuari i Password --------
const errorMail = document.getElementById('errorMail')
const mail = document.getElementById('register_mail')

mailValid = false

// -------- Comprovar formulari --------
form.addEventListener('submit', (e) => {
    e.preventDefault()

    checkMail()
        .then(result => {
            if(result) {
                mailValid = true
                errorMail.innerText = ""
            } else {
                mailValid = false
                errorMail.innerText = "Cap compte registrat amb aquest correu."
            }
        })
        .catch(error => {
            console.error("Error:", error)
            alert("Error al comprovar el correu")
    })

    if(mailValid){
        var formAtributs = document.createElement('input')
        formAtributs.setAttribute('type','hidden')
        formAtributs.setAttribute('name','forgotpass')
        formAtributs.setAttribute('value','Enviar')
        form.appendChild(formAtributs)
        form.submit()
    }
})

// Comprovar base de dades

function checkMail() {
    const formData = new FormData();
    formData.append('mail',mail.value)
    return new Promise((resolve,reject) => {
        fetch('revisarMail.php', { // Mirem la base de dades amb php
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data)
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