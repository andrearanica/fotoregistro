let userInfo = {}
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
        userInfo = data
        /*
        userInfo.surname = data.surname
        userInfo.student_id = data.student_id
        userInfo.email = data.email
        userInfo.photo = data.photo*/

        document.getElementById('title').innerHTML = 'Benvenuto ' + userInfo.name
        if (userInfo.class_id == null) {
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
                            studentId: userInfo.id
                        },
                        dataType: 'json',
                        success: (data) => {
                            console.log('Iscritto')
                            userInfo.classId = decodedText
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
                    classId: userInfo.class_id
                },
                success: (data) => {
                    classInfo = data
                    document.getElementById('user-alert').className = 'alert'
                    document.getElementById('user-alert').innerHTML = `<p>Classe ${ classInfo[0].name }</h1>`
                }
            })
            if (userInfo.photo == 1) {
                document.getElementById('user-alert').className = 'alert alert-success'
            } else {
                document.getElementById('user-alert').className = 'alert alert-warning'
                
            }
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

document.getElementById('click-photo').addEventListener('click', () => {
    let canvas = document.getElementById('canvas')
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height)
    let image_data_url = canvas.toDataURL('image/jpeg')
    
})