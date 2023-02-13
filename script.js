var form = document.getElementById('loginForm')

form.addEventListener('submit', (event) => {
    event.preventDefault()

    $.ajax({
        url: '../php/login.php',
        type: 'GET',
        data: {
            email: document.getElementById('loginEmail').value,
            password: document.getElementById('loginPassword').value
        },
        success: (data) => {
            if (data == '1') {
                console.log('p')
            }
        }
    })
})