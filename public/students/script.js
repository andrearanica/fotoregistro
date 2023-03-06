let userInfo = {}
let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: {
        width: 250,
        height: 250
    },
}, false)
html5QrcodeScanner.render(onScanSuccess)

function onScanSuccess(decodedText, decodedResult) {
    console.log(`Code match = ${ decodedText } ${ decodedResult }`)
}

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
        if (userInfo.photo == 0) {
            document.getElementById('user-alert').className = 'alert alert-warning'
            document.getElementById('user-alert').innerHTML = '<b>Non hai ancora caricato la tua foto</b>'
        }
    },
    error: (data) => {
        console.log(data)
    }
})