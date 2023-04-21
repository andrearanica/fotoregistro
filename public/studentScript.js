let user = {}
let classInfo = {}

$.ajax({
    url: 'ajax?request=infoFromJwt&type=students',
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
                if (decodedText.includes('cl')) {
                    $.ajax({
                        url: 'ajax?request=subscribe',
                        type: 'POST',
                        headers: {
                            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                        },
                        data: {
                            classId: decodedText,
                            studentId: user.student_id
                        },
                        dataType: 'json',
                        success: (data) => {
                            console.log('Iscritto')
                            location.reload()
                        },
                        error: (error) => {
                            console.log(error)
                        }
                    })
                }
            }
        } else {
            document.getElementById('subscribe-form').style = 'display: none;'
            $.ajax({
                url: `ajax?request=class&class_id=${ user.class_id }`,
                type: 'GET',
                headers: {
                    Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                },
                dataType: 'json',
                /*data: {
                    class_id: user.class_id
                },*/
                success: (data) => {
                    classInfo = data
                    console.log(classInfo)
                    document.getElementById('user-alert').className = 'alert alert-success'
                    document.getElementById('user-alert').innerHTML = `<b>Sei iscritto alla classe ${ classInfo[0].class_name }</b>`
                    document.getElementById('unsubscribe').style = '';
                },
                error: data => {
                    console.log(data)
                }
            })
        }

        if (user.photo) {
            document.getElementById('start-camera').style = 'display: none';
            document.getElementById('upload-photo').style = 'display: none';
            document.getElementById('student-photo').src = `../app/photos/${ user.student_id }.png`
            document.getElementById('messages').innerHTML = 'Questa è la tua foto. Se non ti piace, puoi <a id="remove-photo">ricaricarla</a>'
            document.getElementById('remove-photo').addEventListener('click', () => {
                removePhoto(user.student_id)
            })
        } else {
            document.getElementById('start-camera').style = '';
            document.getElementById('messages').innerHTML += 'Non hai ancora caricato la foto: è il momento giusto per farlo!'
        }
    },
    error: (data) => {
        console.log(data)
    }
})

let video = document.getElementById('video')

document.getElementById('start-camera').addEventListener('click', async () => {
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    video.srcObject = stream
})

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
    $.ajax({
        url: 'ajax?request=remove-image',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            student_id: id
        }
    })
    location.reload()
}

document.getElementById('save-photo').addEventListener('click', () => {
    $.ajax({
        url: 'ajax?request=save-photo',
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
    location.reload()
})

document.getElementById('unsubscribe').addEventListener('click', () => {
    $.ajax({
        url: 'ajax?request=unsubscribe',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            student_id: user.student_id
        },
        success: data => {
            location.reload()
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
        url: 'ajax?request=subscribe',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            classId: document.getElementById('class-id').value,
            studentId: user.student_id
        },
        dataType: 'json',
        success: data => {
            location.reload()
        },
        error: data => {
            console.log(data)
            document.getElementById('subscribe-errors').className = 'alert alert-danger text-center my-4'            
            document.getElementById('subscribe-errors').innerHTML = '<b>Classe non trovata</b>'            
        }
    })
})

document.getElementById('logout').addEventListener('click', () => {
    window.localStorage.setItem('token', '')
    window.location.href = '../public'
})

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
        url: '../../php/updateAccount.php',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            type: 'students',
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