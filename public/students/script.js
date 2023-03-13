let userInfo = {}

$.ajax({
    url: '../../php/jwt.php?type=students',
    type: 'POST',
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
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
                    console.log(data)
                    document.getElementById('user-alert').innerHTML = `<h1>Sei iscritto alla classe ${ data[0].name }</h1>`
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