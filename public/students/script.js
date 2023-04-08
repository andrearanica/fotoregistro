let user = {}
let classInfo = {}

$.ajax({
    url: '../../php/jwt.php?type=students',
    type: 'POST',
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

        if (user.class_id == null) {
            document.getElementById('user-alert').className = 'alert alert-warning'
            document.getElementById('user-alert').innerHTML = '<b>Non sei ancora iscritto alla tua classe</b>'
            let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
            }, false)
            html5QrcodeScanner.render(onScanSuccess)
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText.includes('cl')) {
                    $.ajax({
                        url: '../../php/subscribeToClass.php',
                        type: 'POST',
                        data: {
                            classId: decodedText,
                            studentId: user.student_id
                        },
                        dataType: 'json',
                        success: (data) => {
                            console.log('Iscritto')
                            user.classId = decodedText
                            document.getElementById('user-alert').className = 'alert alert-success my-2'
                            document.getElementById('user-alert').innerHTML = '<b>Sei stato iscritto</b>'
                        },
                        error: (error) => {
                            console.log(error)
                        }
                    })
                }
            }
        } else {
            $.ajax({
                url: '../../php/getClasses.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    class_id: user.class_id
                },
                success: (data) => {
                    classInfo = data
                    console.log(classInfo)
                    document.getElementById('user-alert').className = 'alert alert-success'
                    document.getElementById('user-alert').innerHTML = `<b>Sei iscritto alla classe ${ classInfo[0].class_name }</b>`
                    document.getElementById('unsubscribe').style = '';
                }
            })
        }

        if (user.photo) {
            document.getElementById('start-camera').style = 'display: none';
            document.getElementById('upload-photo').style = 'display: none';
            document.getElementById('student-photo').src = `../../photos/${ user.student_id }.png`
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
        url: '../../php/upload.php?remove',
        type: 'POST',
        data: {
            student_id: id
        }
    })
    location.reload()
}

document.getElementById('save-photo').addEventListener('click', () => {
    $.ajax({
        url: '../../php/upload.php',
        type: 'POST',
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
        url: '../../php/unsubscribe.php',
        type: 'POST',
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
    $.ajax({
        url: '../../php/subscribeToClass.php',
        type: 'POST',
        data: {
            classId: document.getElementById('class-id'),
            studentId: user.student_id
        },
        dataType: 'json',
        success: (data) => {
            console.log('Iscritto')
            user.classId = decodedText
            document.getElementById('user-alert').className = 'alert alert-success my-2'
            document.getElementById('user-alert').innerHTML = '<b>Sei stato iscritto</b>'
        },
        error: (error) => {
            console.log(error)
        }
    })
})