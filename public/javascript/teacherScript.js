let user = {}
let classes = []

function getClasses () {
    $.ajax({
        url: `ajax?request=class&teacher_id=${ user.teacher_id }`,
        type: 'GET',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        success: data => {
            console.log(data)
            // console.log(`Classi di questo insegnante: ${ data }`)
            document.getElementById('classes').innerHTML = '<div class="row">'
            data.map(c => document.getElementById('classes').innerHTML += `
            <div class="col">
                <center><div class='card my-2' style='width: 18rem; margin: auto; '>
                    <div class='card-body'>
                        <h5 class='card-title'>Classe ${ c.class_name }</h5>
                        <button onclick="showClass('${ c.class_id }')" class='btn btn-success my-1  ' id='showClassButton'>Visualizza classe</button><br>
                        <button onclick="unsubscribeFromClass('${ c.class_id }')" class='btn btn-warning my-1'>Disiscriviti</button><br>
                        <button onclick="removeClass('${ c.class_id }')" class='btn btn-danger my-1'>Rimuovi</button>
                    </div>
                </div></center>
            </div>
            `)
            document.getElementById('classes').innerHTML += '</div>'
        },
        error: data => {
            console.log(data)
        }
    })
}

function createClass (token, className, classAccessType, teacher_id) {
    $.ajax({
        url: 'new-class',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            token: token,
            class_name: className,
            teacher_id: user.teacher_id
        },
        success: data => {
            console.log(data)
            document.getElementById('newClassAlert').className = 'alert alert-success my-2'
            document.getElementById('newClassAlert').innerHTML = '<b>Classe creata con successo</b>'
            getClasses()
        },
        error: data => {
            console.log(data)
        }
    })
}

function removeClass (class_id) {
    $.ajax({
        url: 'remove-class',
        type: 'POST',
        dataType: 'json',
        data: {
            class_id: class_id
        },
        success: data => {
            console.log(data)
            getClasses()
        },
        error: data => {
            console.log(data)
        }
    })
}

function unsubscribeFromClass (class_id) {
    $.ajax({
        url: 'unsubscribe-teacher',
        type: 'POST',
        dataType: 'json',
        data: {
            teacher_id: user.teacher_id,
            class_id: class_id
        },
        success: data => {
            console.log(data)
        },
        error: data => {
            console.log(data)
        }
    })
}

$.ajax({
    url: 'ajax?request=infoFromJwt&type=teachers',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
        user = data
        console.log(user)

        document.getElementById('title').innerHTML = 'Benvenuto ' + user.name
        // Fill account form
        document.getElementById('account-name').value = user.name
        document.getElementById('account-surname').value = user.surname
        document.getElementById('account-email').value = user.email

        getClasses()
    },
    error: (data) => {
        console.log(data)
    }
})

document.getElementById('newClassForm').addEventListener('submit', event => {
    event.preventDefault()
    $.ajax({
        url: 'new-class',
        type: 'POST',
        dataType: 'json',
        data: {
            class_name: document.getElementById('newClassName').value,
            teacher_id: user.teacher_id
        },
        success: data => {
            console.log(data)
            if (data.message == 'ok') {
                document.getElementById('newClassAlert').className = 'alert alert-success my-2'
                document.getElementById('newClassAlert').innerHTML = '<b>Classe creata con successo</b>'
                getClasses()
            } else {
                document.getElementById('newClassAlert').className = 'alert alert- my-2'
                document.getElementById('newClassAlert').innerHTML = '<b>Classe creata con successo</b>'
            }
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('logout').addEventListener('click', () => {
    window.localStorage.clear()
    window.location.href = '../publics'
})

function showClass (classId) {
    window.location.href = `./class?id=${ classId }` 

}

document.getElementById('account-info-form').addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById('account-alert').className = ''
    document.getElementById('account-alert').innerHTML = ''
    if (document.getElementById('account-password').value != document.getElementById('account-password-confirm').value) {
        document.getElementById('account-alert').className = 'alert alert-danger my-2'
        document.getElementById('account-alert').innerHTML = '<b>Le password non corrispondono</b>'
        return
    }
    $.ajax({
        url: 'update-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            type: 'teachers',
            name: document.getElementById('account-name').value,
            surname: document.getElementById('account-surname').value,
            email: document.getElementById('account-email').value,
            password: document.getElementById('account-password').value
        },
        success: data => {
            if (data.message == 'ok') {
                document.getElementById('account-alert').className = 'alert alert-success my-2'
                document.getElementById('account-alert').innerHTML = '<b>Account modificato</b>'
            } else {
                document.getElementById('account-alert').className = 'alert alert-danger my-2'
                document.getElementById('account-alert').innerHTML = '<b>Qualcosa è andato storto</b>'
            }
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('reset-account-info').addEventListener('click', () => {
    document.getElementById('account-name').value = user.name
    document.getElementById('account-surname').value = user.surname
    document.getElementById('account-email').value = user.email
    document.getElementById('account-password').value = user.password
    document.getElementById('account-password-confirm').value = user.password
})

document.getElementById('subscribe-form').addEventListener('submit', (e) => {
    e.preventDefault()
    $.ajax({
        url: 'subscribe-teacher',
        type: 'POST',
        data: {
            teacher_id: user.teacher_id,
            class_id: document.getElementById('subscribe-class-id').value
        },
        dataType: 'json',
        success: data => {
            getClasses()
            console.log(data)
            if (data.message == 'ok') {
                document.getElementById('subscribe-alert').className = 'alert alert-success my-2'
                document.getElementById('subscribe-alert').innerHTML = '<b>Iscrizione avvenuta con successo</b>'
            } else {
                document.getElementById('subscribe-alert').className = 'alert alert-danger'
            document.getElementById('subscribe-alert').innerHTML = '<b>Classe non trovata</b>'
            }
        },
        error: data => {
            console.log(data)
            document.getElementById('subscribe-alert').className = 'alert alert-danger'
            document.getElementById('subscribe-alert').innerHTML = '<b>Classe non trovata</b>'
        }
    })
})