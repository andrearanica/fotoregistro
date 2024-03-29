let user = {}
let classes = []

function clean (element) {
    setTimeout(()=> {
        element.className = ''
        element.innerHTML = ''
    }, 2000)
}

$.ajax({
    url: 'check-token',
    type: 'POST',
    data: {
        token: window.localStorage.getItem('token')
    },
    dataType: 'json',
    success: data => {
        if (data.message === 'error') {
            window.location.href = '../public/login'
        }
    },
    error: data => {
        console.log(data)
    }
})

function getClasses () {
    $.ajax({
        url: `teacher-classes`,
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            teacher_id: user.teacher_id
        },
        success: data => {
            console.log(data)
            // console.log(`Classi di questo insegnante: ${ data }`)
            document.getElementById('classes').className = ''
            document.getElementById('classes').innerHTML = '<div class="row">'
            if (data.length > 0) {
                data.map(c => document.getElementById('classes').innerHTML += `
                <div class="col">
                    <center><div class='card my-2' style='width: 18rem; margin: auto; '>
                        <div class='card-body'>
                            <button type='button' class='btn' data-bs-toggle='modal' data-bs-target='#class-info-modal' onclick='editClass(${ c.class_id })'>
                                ✏️
                            </button>
                            <h5 class='card-title'><b>Classe ${ c.class_name }</b></h5>
                            <button onclick="showClass('${ c.class_id }')" class='btn btn-success my-1  ' id='showClassButton'>Visualizza classe</button><br>
                            <button onclick="unsubscribeFromClass('${ c.class_id }')" class='btn btn-warning my-1'>Disiscriviti</button><br>
                            <button onclick="removeClass('${ c.class_id }')" class='btn btn-danger my-1'>Rimuovi</button>
                        </div>
                    </div></center>
                </div>
                `)
                document.getElementById('classes').innerHTML += '</div>'
            } else {
                document.getElementById('classes').className = 'alert alert-warning text-center'
                document.getElementById('classes').innerHTML = 'Non sei iscritto a nessuna classe'
            }
        },
        error: data => {
            console.log(data)
        }
    })
}

function editClass (class_id) {
    $.ajax({
        url: 'class-info',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            class_id: class_id
        },
        success: data => {
            document.getElementById('edit-class-id').value = data[0].class_id
            document.getElementById('edit-class-name').value = data[0].class_name
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
    if (!confirm(`Sei sicuro di voler eliminare la classe? Perderai tutte le informazioni sui tuoi studenti`)) {
        return
    }
    $.ajax({
        url: 'remove-class',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            class_id: class_id
        },
        success: data => {
            console.log(data)
            getClasses()
            document.getElementById('message-div').className = 'alert alert-success'
            document.getElementById('message-div').innerHTML = '<b>Classe eliminata con successo</b>'
            clean(document.getElementById('message-div'))
        },
        error: data => {
            console.log(data)
        }
    })
}

function unsubscribeFromClass (class_id) {
    if (!confirm(`Sei sicuro di volerti disiscrivere da questa classe?`)) {
        return
    }
    $.ajax({
        url: 'unsubscribe-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            teacher_id: user.teacher_id,
            class_id: class_id
        },
        success: data => {
            console.log(data)
            getClasses()
            if (data.message == 'ok') {
                document.getElementById('message-div').className = `alert alert-success my-4`
                document.getElementById('message-div').innerHTML = '<b>Ti sei disiscritto dalla classe</b>'
                clean(document.getElementById('message-div'))
            }
        },
        error: data => {
            console.log(data)
        }
    })
}

$.ajax({
    url: 'info-from-jwt-teacher',
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

        try {
            console.log(user.teacher_id)
        } catch (exception) {
            window.location.href = '../public'
        }

        document.getElementById('title').innerHTML = 'Benvenuto ' + user.name
        // Fill account form
        document.getElementById('account-name').value = user.name
        document.getElementById('account-surname').value = user.surname

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
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
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
                document.getElementById('newClassAlert').className = 'alert alert-danger my-2'
                document.getElementById('newClassAlert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
            }
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('logout').addEventListener('click', () => {
    window.localStorage.clear()
    window.location.href = '../public'
})

function showClass (classId) {
    window.location.href = `./class?id=${ classId }` 

}

document.getElementById('account-info-form').addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById('account-alert').className = ''
    document.getElementById('account-alert').innerHTML = ''
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
            email: user.email,
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
})

document.getElementById('subscribe-form').addEventListener('submit', (e) => {
    e.preventDefault()
    $.ajax({
        url: 'subscribe-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
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
                document.getElementById('subscribe-alert').className = 'alert alert-danger my-2'
                document.getElementById('subscribe-alert').innerHTML = '<b>Operazione impossibile: controlla l\'id della classe e che tu non sia già iscritto</b>'
            }
            clean(document.getElementById('subscribe-alert'))
        },
        error: data => {
            console.log(data)
            document.getElementById('subscribe-alert').className = 'alert alert-danger'
            document.getElementById('subscribe-alert').innerHTML = '<b>Classe non trovata</b>'
        }
    })
})

document.getElementById('account-password-form').addEventListener('submit', (e) => {
    e.preventDefault()
    if (document.getElementById('new-password').value !== document.getElementById('confirm-new-password').value) {
        document.getElementById('account-alert').className = 'alert alert-danger'
        document.getElementById('account-alert').innerHTML = '<b>Le password inserite non combaciano</b>'
        return
    }
    $.ajax({
        url: 'edit-password-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            email: user.email,
            password: document.getElementById('new-password').value
        },
        dataType: 'json',
        success: data => {
            if (data.message == 'ok') {
                document.getElementById('account-alert').className = 'alert alert-success'
                document.getElementById('account-alert').innerHTML = '<b>Password aggiornata con successo</b>'
            } else {
                document.getElementById('account-alert').className = 'alert alert-danger'
                document.getElementById('account-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
            }
        },
        error: data => {
            document.getElementById('account-alert').className = 'alert alert-danger'
            document.getElementById('account-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
        }
    })
})

document.getElementById('edit-class-form').addEventListener('submit', (e) => {
    e.preventDefault()
    $.ajax({
        url: 'edit-class',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            class_id: document.getElementById('edit-class-id').value,
            class_name: document.getElementById('edit-class-name').value
        },
        dataType: 'json',
        success: data => {
            getClasses()
            if (data.message === 'ok') {
                document.getElementById('class-edit-alert').className = 'alert alert-success my-2'
                document.getElementById('class-edit-alert').innerHTML = '<b>Classe modificata con successo</b>'
            } else {
                document.getElementById('class-edit-alert').className = 'alert alert-danger my-2'
                document.getElementById('class-edit-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
            }
            clean(document.getElementById('class-edit-alert'))
        },
        error: data => {
            document.getElementById('class-edit-alert').className = 'alert alert-danger my-2'
            document.getElementById('class-edit-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
            clean(document.getElementById('class-edit-alert'))
        }
    })
})