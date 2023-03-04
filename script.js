var loginForm = document.getElementById('loginForm')
var signupForm = document.getElementById('signupForm')

let showPassword = false

loginForm.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('loginAlert').className = ''
    document.getElementById('loginAlert').innerHTML = ''
    $.ajax({
        url: '../php/login.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email: document.getElementById('loginEmail').value,
            password: document.getElementById('loginPassword').value
        },
        success: (data) => {
            console.log(data)
            if (data.message == 'ok') {
                console.log(data)
            } else if (data.message == 'user not enabled') {
                document.getElementById('loginAlert').className = 'alert alert-warning text-center'
                document.getElementById('loginAlert').innerHTML = '<b>Devi abilitare l\'account</b> seguendo la mail che ti è stata inviata'
            } else {
                document.getElementById('loginAlert').className = 'alert alert-danger text-center'
                document.getElementById('loginAlert').innerHTML = '<b>Username e/o password errati</b>'
            }
        }
    })
})

signupForm.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('signupAlert').className = ''
    document.getElementById('signupAlert').innerHTML = ''
    if (document.getElementById('signupPassword').value !== document.getElementById('signupConfirmPassword').value) {
        document.getElementById('signupAlert').className = 'alert alert-danger text-center'
        document.getElementById('signupAlert').innerHTML = '<b>Le password non combaciano</b>'
        return
    }
    $.ajax({
        url: '../php/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            name: document.getElementById('signupName').value,
            surname: document.getElementById('signupSurname').value,
            email: document.getElementById('signupEmail').value,
            password: document.getElementById('signupPassword').value
        },
        success: (data) => {
            console.log(data)
            if (data.message == 'ok') {
                document.getElementById('signupAlert').className = 'alert my-2 alert-success text-center'
                document.getElementById('signupAlert').innerHTML = '<b>Registrazione effettuata correttamente, effettua il login</b>'
            }
        }
    })
})

document.getElementById('showPassword').onchange = () => {
    
}