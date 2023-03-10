let userInfo = {}

$.ajax({
    url: '../../php/jwt.php?type=students',
    type: 'POST',
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
        userInfo.name = data.name
        userInfo.surname = data.surname
        userInfo.email = data.email
        userInfo.photo = data.photo

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
                            studentId: userInfo.student_id
                        },
                        dataType: 'json',
                        success: (data) => {
                            console.log('Iscritto')
                        },
                        error: (error) => {
                            console.log(error)
                        }
                    })
                }
            }
        }
    },
    error: (data) => {
        console.log(data)
    }
})