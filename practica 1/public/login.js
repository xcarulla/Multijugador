const form = document.getElementById('form')
// -------- ReCaptcha --------

const errorElementCaptcha = document.getElementById('errorReCaptcha')
recaptchaChecked = false

function recaptchaCallback() {
    recaptchaChecked = true
};

// -------- Usuari i Password --------
const errorDades = document.getElementById('errorDades')
const username = document.getElementById('login_username')
const password = document.getElementById('login_password')

dadesValid = false

// -------- Comprovar formulari --------
form.addEventListener('submit', (e) => {
    e.preventDefault()

    checkDades()
        .then(result => {
            if(result) {
                dadesValid = true
                errorDades.innerText = ""
            } else {
                dadesValid = false
                errorDades.innerText = "Dades incorrectes o correu no verificat."
            }
        })
        .catch(error => {
            console.error("Error:", error)
            alert("Error al verificar les dades")
    })

    if(!recaptchaChecked){
        errorElementCaptcha.innerText = "ReCaptcha necessari."
    } else errorElementCaptcha.innerText = ""

    if(recaptchaChecked && dadesValid){
        var formAtributs = document.createElement('input')
        formAtributs.setAttribute('type','hidden')
        formAtributs.setAttribute('name','login')
        formAtributs.setAttribute('value','Iniciar sessió')
        form.appendChild(formAtributs)
        console.log("hola")
        form.submit()
    }
})

// Comprovar base de dades

function checkDades() {
    const formData = new FormData();
    formData.append('user_name',username.value)
    formData.append('password',password.value)
    formData.append('lookat','dades')

    return new Promise((resolve,reject) => {
        fetch('verificarDadesLogin.php', { // Mirem la base de dades amb php
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