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
                            studentId: user.id
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
                    document.getElementById('user-alert').className = 'alert'
                    document.getElementById('user-alert').innerHTML = `<p>Sei iscritto alla classe ${ classInfo[0].class_name }</h1>`
                }
            })
            if (user.photo == 1) {
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