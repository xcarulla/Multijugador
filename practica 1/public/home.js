document.getElementById('logoutButton').addEventListener('click', function() {
    const formData = new FormData()
    formData.append('lookat','logout')

    fetch('homeFunctions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = '/?page=login';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al realizar la solicitud.');
    });
});
const username = document.getElementById('username')

document.getElementById('deleteAccount').addEventListener('click', function() {
    const formData = new FormData()
    formData.append('lookat','deleteAccount')
    formData.append('user_name',username.value)
    console.log(username.value)
    fetch('homeFunctions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        window.location.href = '/?page=login';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al realizar la solicitud.');
    });
});