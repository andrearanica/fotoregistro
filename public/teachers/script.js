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
        userInfo.id = data.id
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

$.ajax({
    url: '../../php/getAllClasses.php',
    type: 'GET',
    dataType: 'json',
    success: data => {
        console.log(data)
        for (let i = 0; i < data.length; i++) {
            document.getElementById('newClassSchoolId').innerHTML += `<option value=${ data[i].school_id }>${ data[i].name }</option>`
        }
    },
    error: data => {
        console.error(data)
    }
})

$.ajax({
    url: `../../php/getClasses.php?teacher_id=${ userInfo.teacherId }`,
    type: 'GET',
    dataType: 'json',
    success: data => {
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
            classAccessType: document.getElementById('newClassAccessType').value,
            classSchoolId: document.getElementById('newClassSchoolId').value,
            teacherId: userInfo.id
        },
        success: data => {
            console.log(data)
        },
        error: data => {
            console.log(data)
        }
    })
})