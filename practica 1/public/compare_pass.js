const password = document.getElementById('password')
const password_copy = document.getElementById('password_copy')
const form = document.getElementById('form')
const errorElement = document.getElementById('error')

form.addEventListener('submit', (e) => {
    if(password.value != password_copy.value){
        e.preventDefault()
        errorElement.innerText = "La contrassenya no coincideix."
    }
})