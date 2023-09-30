document.getElementById('logoutButton').addEventListener('click', function() {
    fetch('logout.php', {
        method: 'POST',
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