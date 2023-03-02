var loginForm = document.getElementById('loginForm')
var signupForm = document.getElementById('signupForm')

let showPassword = false

loginForm.addEventListener('submit', (event) => {
    event.preventDefault()
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
        }
    })
})

signupForm.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('signupAlert').className = ''
    if (document.getElementById('signupPassword').value !== document.getElementById('signupConfirmPassword').value) {
        document.getElementById('signupAlert').className = 'alert alert-danger text-center'
        document.getElementById('signupAlert').innerHTML = '<b>Le password non combaciano</b>'
        return
    }
    $.ajax({
        url: '../php/signup.php',
        type: 'POST',
        data: {
            name: document.getElementById('signupName').value,
            surname: document.getElementById('signupSurname').value,
            email: document.getElementById('signupEmail').value,
            password: document.getElementById('signupPassword').value
        },
        success: (data) => {
            console.log(data)
        }
    })
})

document.getElementById('showPassword').onchange = () => {
    
}