var loginFormStudent = document.getElementById('loginFormStudent')
var signupFormStudent = document.getElementById('signupFormStudent')
var loginFormTeacher = document.getElementById('loginFormTeacher')
var signupFormTeacher = document.getElementById('signupFormTeacher')

loginFormStudent.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('loginAlertStudent').className = ''
    document.getElementById('loginAlertStudent').innerHTML = ''
    $.ajax({
        url: 'student-login',
        type: 'POST',
        dataType: 'json',
        data: {
            email: document.getElementById('loginEmailStudent').value,
            password: document.getElementById('loginPasswordStudent').value
        },
        success: (data) => {
            // console.log(data)
            if (data.message == 'user not enabled') {
                document.getElementById('loginAlertStudent').className = 'alert alert-warning text-center'
                document.getElementById('loginAlertStudent').innerHTML = '<b>Devi abilitare l\'account</b> seguendo la mail che ti è stata inviata'
            } else if (data.message == 'user not found') {
                document.getElementById('loginAlertStudent').className = 'alert alert-danger text-center'
                document.getElementById('loginAlertStudent').innerHTML = '<b>Username e/o password errati</b>'
            } else {
                window.localStorage.setItem('token', data.message)
                window.location.href = './student'
            }
        },
        error: (data) => {
            console.log(data)
        }
    })
})

signupFormStudent.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('signupAlertStudent').className = ''
    document.getElementById('signupAlertStudent').innerHTML = ''
    if (document.getElementById('signupPasswordStudent').value !== document.getElementById('signupConfirmPasswordStudent').value) {
        document.getElementById('signupAlertStudent').className = 'alert alert-danger text-center'
        document.getElementById('signupAlertStudent').innerHTML = '<b>Le password non combaciano</b>'
        return
    }
    $.ajax({
        url: 'student-signup ',
        type: 'POST',
        dataType: 'json',
        data: {
            name: document.getElementById('signupNameStudent').value,
            surname: document.getElementById('signupSurnameStudent').value,
            email: document.getElementById('signupEmailStudent').value,
            password: document.getElementById('signupPasswordStudent').value
        },
        success: (data) => {
            console.log(data)
            if (data.message == 'ok') {
                document.getElementById('signupAlertStudent').className = 'alert my-2 alert-success text-center'
                document.getElementById('signupAlertStudent').innerHTML = '<b>Registrazione effettuata correttamente, effettua il login</b>'
            }
        },
        error: (data) => {
            console.log(data)
            document.getElementById('signupAlertStudent').className = 'alert alert-danger my-2 text-center'
            document.getElementById('signupAlertStudent').innerHTML = '<b>Questa email è già in uso</b>'
        }
    })
})

function showPasswordStudent (form) {
    if (form == 'login') {
        var x = document.getElementById('loginPasswordStudent')
    } else {
        var x = document.getElementById('signupPasswordStudent')
    }
    if (x.type == 'password') {
        x.type = 'text'
        if (form == 'login') {
            document.getElementById('show-password-student-login').value = '👁️'
        } else {
            document.getElementById('show-password-student-signup').value = '👁️'
        }
    } else {
        x.type = 'password'
        if (form == 'login') {
            document.getElementById('show-password-student-login').value = '❌'
        } else {
            document.getElementById('show-password-student-signup').value = '❌'
        }
    }
}

function showPasswordTeacher (form) {
    if (form == 'login') {
        var x = document.getElementById('loginPasswordTeacher')
    } else {
        var x = document.getElementById('signupPasswordTeacher')
    }
    if (x.type == 'password') {
        x.type = 'text'
        if (form == 'login') {
            document.getElementById('show-password-teacher-login').value = '👁️'
        } else {
            document.getElementById('show-password-teacher-signup').value = '👁️'
        }
    } else {
        x.type = 'password'
        if (form == 'login') {
            document.getElementById('show-password-teacher-login').value = '❌'
        } else {
            document.getElementById('show-password-teacher-signup').value = '❌'
        }
    }
}

loginFormTeacher.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('loginAlertTeacher').className = ''
    document.getElementById('loginAlertTeacher').innerHTML = ''
    $.ajax({
        url: 'teacher-login',
        type: 'POST',
        dataType: 'json',
        data: {
            email: document.getElementById('loginEmailTeacher').value,
            password: document.getElementById('loginPasswordTeacher').value
        },
        success: (data) => {
            console.log(data)
            if (data.message == 'user not enabled') {
                document.getElementById('loginAlertTeacher').className = 'alert alert-warning text-center'
                document.getElementById('loginAlertTeacher').innerHTML = '<b>Devi abilitare l\'account</b> seguendo la mail che ti è stata inviata'
            } else if (data.message == 'user not found') {
                document.getElementById('loginAlertTeacher').className = 'alert alert-danger text-center'
                document.getElementById('loginAlertTeacher').innerHTML = '<b>Username e/o password errati</b>'
            } else {
                window.localStorage.setItem('token', data.message)
                window.location.href= './teacher'
            }
        },
        error: (data) => {
            console.log(data)
        }
    })
})

signupFormTeacher.addEventListener('submit', (event) => {
    event.preventDefault()
    document.getElementById('signupAlertTeacher').className = ''
    document.getElementById('signupAlertTeacher').innerHTML = ''
    if (document.getElementById('signupPasswordTeacher').value !== document.getElementById('signupConfirmPasswordTeacher').value) {
        document.getElementById('signupAlertTeacher').className = 'alert alert-danger text-center'
        document.getElementById('signupAlertTeacher').innerHTML = '<b>Le password non combaciano</b>'
        return
    }
    $.ajax({
        url: 'teacher-signup ',
        type: 'POST',
        dataType: 'json',
        data: {
            name: document.getElementById('signupNameTeacher').value,
            surname: document.getElementById('signupSurnameTeacher').value,
            email: document.getElementById('signupEmailTeacher').value,
            password: document.getElementById('signupPasswordTeacher').value
        },
        success: (data) => {
            console.log(data)
            if (data.message == 'ok') {
                document.getElementById('signupAlertTeacher').className = 'alert my-2 alert-success text-center'
                document.getElementById('signupAlertTeacher').innerHTML = '<b>Registrazione effettuata correttamente, controlla la tua email</b>'
            }
        },
        error: (data) => {
            console.log(data)
            document.getElementById('signupAlertTeacher').className = 'alert alert-danger my-2 text-center'
            document.getElementById('signupAlertTeacher').innerHTML = '<b>Questa email è già in uso</b>'
        }
    })
})