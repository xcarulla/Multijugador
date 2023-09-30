// -------- ReCaptcha --------

const errorElementCaptcha = document.getElementById('errorReCaptcha')
recaptchaChecked = false

function recaptchaCallback() {
    recaptchaChecked = true
};

// -------- Mail i Usuari --------
const errorUsername = document.getElementById('errorUsername')
const errorUsermail = document.getElementById('errorUsermail')
const errorRegister = document.getElementById('errorRegister')
const username = document.getElementById('register_username')
const usermail = document.getElementById('register_mail')
const userpassword = document.getElementById('password')

usernameValid = false
usermailValid = false
userRegistred = false

// -------- Comprovar formulari --------
form.addEventListener('submit', (e) => {
    e.preventDefault()

    checkUsername()
        .then(result => {
            if(result) {
                usernameValid = true
                errorUsername.innerText = ""
            } else {
                usernameValid = false
                errorUsername.innerText = "Nom d'usuari ja existent."
            }
        })
        .catch(error => {
            console.error("Error:", error)
            alert("Error al verificar les dades")
        })

    checkUsermail()
        .then(result => {
            if(result) {
                usermailValid = true
                errorUsermail.innerText = ""
            } else {
                usermailValid = false
                errorUsermail.innerText = "Email ja registrat."
            }
        })
        .catch(error => {
            console.error("Error:", error)
            alert("Error al verificar les dades")
    })

    if(!recaptchaChecked){
        errorElementCaptcha.innerText = "ReCaptcha necessari."
    } else errorElementCaptcha.innerText = ""

    if(usernameValid && recaptchaChecked && usermailValid){
        registerUser()
            .then(result => {
                if(result) {
                    userRegistred = true
                    errorRegister.innerText = ""
                } else {
                    userRegistred = false
                    errorRegister.innerText = "Error al registrar."
                }
            })
            .catch(error => {
                console.error("Error:", error)
                alert("Error al verificar les dades")
        })

        if (userRegistred){
            var formAtributs = document.createElement('input')
            formAtributs.setAttribute('type','hidden')
            formAtributs.setAttribute('name','register')
            formAtributs.setAttribute('value','Registrar-se')
            form.appendChild(formAtributs)
            
            form.submit()
        }
    }
})

// Comprovar base de dades

function checkUsername() {
    const formData = new FormData();
    formData.append('dada',username.value)
    formData.append('lookat','username')

    return new Promise((resolve,reject) => {
        fetch('verificarDadesRegistre.php', {
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

function checkUsermail() {
    const formData = new FormData();
    formData.append('dada',usermail.value)
    formData.append('lookat','usermail')

    return new Promise((resolve,reject) => {
        fetch('verificarDadesRegistre.php', {
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

function registerUser() {
    const formData = new FormData();
    formData.append('user_name', username.value)
    formData.append('user_mail', usermail.value)
    formData.append('user_password', userpassword.value)

    return new Promise((resolve, reject) => {
        fetch('registerUser.php', {
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