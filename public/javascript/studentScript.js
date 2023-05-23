let user = {}
let classInfo = {}

document.getElementById('body').addEventListener('load', getStudentInfo())

$.ajax({
    url: 'check-token',
    type: 'POST',
    data: {
        token: window.localStorage.getItem('token')
    },
    dataType: 'json',
    success: data => {
        if (data.message === 'error') {
            window.location.href = '../public'
        }
    },
    error: data => {
        console.log(data)
    }
})

function getStudentInfo () {
    $.ajax({
        url: 'info-from-jwt-student',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            token: window.localStorage.getItem('token')
        },
        success: (data) => {
            console.log(data)
            user = data

            try {
                console.log(user.student_id)
            } catch (exception) {
                window.location.href = '../public'
            }

            /*
            user.surname = data.surname
            user.student_id = data.student_id
            user.email = data.email
            user.photo = data.photo*/
    
            document.getElementById('title').innerHTML = 'Benvenuto ' + user.name
            document.getElementById('student-id-1').value = user.student_id
            document.getElementById('student-id-2').value = user.student_id
            
            // Fill account form
            document.getElementById('account-name').value = user.name
            document.getElementById('account-surname').value = user.surname
            document.getElementById('account-email').value = user.email
    
            if (user.class_id == null) {
                document.getElementById('unsubscribe').style = 'display: none;';
                document.getElementById('user-alert').className = 'alert alert-warning'
                document.getElementById('user-alert').innerHTML = '<b>Non sei ancora iscritto alla tua classe</b>'
                document.getElementById('subscribe-form').style = ''
                let html5QrcodeScanner = new Html5QrcodeScanner('reader', {
                    fps: 24,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                }, false)
                html5QrcodeScanner.render(onScanSuccess)
                function onScanSuccess(decodedText, decodedResult) {
                    
                        $.ajax({
                            url: 'subscribe-student',
                            type: 'POST',
                            headers: {
                                Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                            },
                            data: {
                                class_id: decodedText,
                                student_id: user.student_id
                            },
                            dataType: 'json',
                            success: (data) => {
                                getStudentInfo()
                                return
                                console.log(`${ data }`)
                                // location.reload()
                            },
                            error: (error) => {
                                console.log(error)
                            }
                        })
                    
                }
            } else {
                document.getElementById('unsubscribe').style = '';
                document.getElementById('subscribe-form').style = 'display: none;'
                $.ajax({
                    url: `class-info`,
                    type: 'POST',
                    headers: {
                        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                    },
                    dataType: 'json',
                    data: {
                        class_id: user.class_id
                    },
                    success: (data) => {
                        classInfo = data[0]
                        document.getElementById('user-alert').className = 'alert alert-success'
                        document.getElementById('user-alert').innerHTML = `<b>Sei iscritto alla classe ${ classInfo.class_name }</b>`
                        document.getElementById('unsubscribe').style = ''
                        $.ajax({
                            url: 'get-students',
                            type: 'POST',
                            headers: {
                                Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                            },
                            data: {
                                class_id: user.class_id
                            },
                            dataType: 'json',
                            success: data => {
                                document.getElementById('user-alert').innerHTML += '<br>Compagni di classe: '
                                for (let i = 0; i < data.length; i++) {
                                    if (data[i].student_id !== user.student_id) {
                                        document.getElementById('user-alert').innerHTML += `${ data[i].name } ${ data[i].surname }`
                                        if (i !== data.length - 1) {
                                            document.getElementById('user-alert').innerHTML += ', '
                                        }
                                    }
                                }
                            },
                            error: data => {
                                console.log(data)
                            }
                        })
                    },
                    error: data => {
                        console.log(data)
                    }
                })
            }
    
            if (user.photo) {
                // document.getElementById('start-camera').style = 'display: none';
                document.getElementById('student-photo').style = '';
                document.getElementById('upload-photo').style = 'display: none';
                document.getElementById('student-photo').src = `../app/photos/${ user.student_id }.${ user.photo_type }`
                // ricaricarla
                document.getElementById('messages').innerHTML = 'Vuoi cambiare foto?<br><a id="remove-photo" class="btn btn-danger">Cancella questa foto</a>'
                document.getElementById('remove-photo').addEventListener('click', () => {
                    removePhoto(user.student_id)
                })
            } else {
                // document.getElementById('start-camera').style = '';
                document.getElementById('messages').className = 'alert alert-warning'
                document.getElementById('messages').innerHTML = 'Non hai ancora caricato una foto: è il momento giusto per farlo!'
                document.getElementById('student-photo').style = 'display: none;'
            }
        },
        error: (data) => {
            console.log(data)
        }
    })
} 

// getStudentInfo()

let video = document.getElementById('video')

/*document.getElementById('start-camera').addEventListener('click', async () => {
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    video.srcObject = stream
})*/

document.getElementById('try-again-photo').addEventListener('click', () => {
    document.getElementById('video').style = ''
    document.getElementById('try-again-photo').style = 'display: none'
    document.getElementById('save-photo').style = 'display: none'
    document.getElementById('click-photo').style = ''
    document.getElementById('canvas').style = 'display: none'
})

document.getElementById('click-photo').addEventListener('click', () => {
    let canvas = document.getElementById('canvas')
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height)
    let image_data_url = canvas.toDataURL('image/jpeg')
    document.getElementById('video').style = 'display: none'
    document.getElementById('try-again-photo').style = ''
    document.getElementById('save-photo').style = ''
    document.getElementById('click-photo').style = 'display: none'
    document.getElementById('canvas').style = ''
})

function removePhoto (id) {
    if (!confirm(`Sei sicuro di voler rimuovere la tua foto?`)) {
        return
    }
    $.ajax({
        url: 'remove-photo',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            student_id: id
        },
        success: () => {
            document.getElementById('student-photo').src = ''
            document.getElementById('student-photo').style = 'display: none;'
            document.getElementById('messages').innerHTML = 'Non hai ancora caricato la foto: è il momento giusto per farlo!'
            document.getElementById('upload-photo').style = ''
        }
    })
}

document.getElementById('save-photo').addEventListener('click', () => {
    $.ajax({
        url: 'save-photo',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            student_id: user.student_id,
            photo: document.getElementById('canvas').toDataURL('image/png')
        },
        success: data => {
            console.log(data)
        },
        error: data => {
            console.log(data)
        }
    })
    // location.reload()
})

document.getElementById('unsubscribe').addEventListener('click', () => {
    if (!confirm(`Sei sicuro di volerti disiscrivere dalla classe ${ classInfo.class_name }?`)) {
        return
    }
    $.ajax({
        url: 'unsubscribe',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            student_id: user.student_id
        },
        success: data => {
            // location.reload()
            console.log(data)
            getStudentInfo()
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('subscribe-to-class').addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById('subscribe-errors').className = ''            
    document.getElementById('subscribe-errors').innerHTML = ''
    $.ajax({
        url: 'subscribe-student',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            class_id: document.getElementById('class-id').value,
            student_id: user.student_id
        },
        dataType: 'json',
        success: data => {
            console.log(data)
            if (data.message == 'ok') {
                getStudentInfo()
            } else if (data.message == 'banned') {
                document.getElementById('subscribe-errors').className = 'alert alert-danger text-center my-4'            
                document.getElementById('subscribe-errors').innerHTML = '<b>Sei stato bannato da questa classe</b>'            
            } else {
                document.getElementById('subscribe-errors').className = 'alert alert-danger text-center my-4'            
            document.getElementById('subscribe-errors').innerHTML = '<b>Classe non trovata</b>'            
            }
        },
        error: data => {
            console.log(data)
            document.getElementById('subscribe-errors').className = 'alert alert-danger text-center my-4'            
            document.getElementById('subscribe-errors').innerHTML = '<b>Classe non trovata</b>'            
        }
    })
})

document.getElementById('account-info-form').addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById('account-alert').className = ''
    document.getElementById('account-alert').innerHTML = ''
    $.ajax({
        url: 'update-student',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            type: 'students',
            name: document.getElementById('account-name').value,
            surname: document.getElementById('account-surname').value,
            email: user.email
        },
        success: data => {
            console.log(data)
            getStudentInfo()
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

document.getElementById('account-password-form').addEventListener('submit', (e) => {
    e.preventDefault()
    if (document.getElementById('new-password').value !== document.getElementById('confirm-new-password').value) {
        document.getElementById('account-alert').className = 'alert alert-danger'
        document.getElementById('account-alert').innerHTML = '<b>Le password inserite non combaciano</b>'
        return
    }
    $.ajax({
        url: 'edit-password-student',
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