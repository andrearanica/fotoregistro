let userInfo = {}

$.ajax({
    url: '../../php/jwt.php?type=teachers',
    type: 'POST',
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
        console.log(data)
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

document.getElementById('newClassForm').addEventListener('submit', event => {
    event.preventDefault()
    $.ajax({
        url: '../../php/addNewClass.php',
        type: 'POST',
        dataType: 'json',
        data: {
            token: window.localStorage.getItem('token'),
            className: document.getElementById('newClassName').value,
            classDescription: document.getElementById('newClassDescription').value,
            classAccessType: document.getElementById('newClassAccessType').value
        },
        success: data => {
            console.log(data)
        },
        error: data => {
            console.log(data)
        }
    })
})