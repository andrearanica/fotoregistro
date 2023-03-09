let userInfo = {}
let classes = []

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
        $.ajax({
            url: `../../php/getClasses.php?teacher_id=${ userInfo.id }`,
            type: 'GET',
            dataType: 'json',
            success: data => {
                // console.log(`Classi di questo insegnante: ${ data }`)
                document.getElementById('classes').innerHTML = '<div class="row">'
                data.map(c => document.getElementById('classes').innerHTML += `<div class="col">
                <center><div class='card my-2' style='width: 18rem; margin: auto; '>
                    <div class='card-body'>
                        <h5 class='card-title'>Classe ${ c.name }</h5>
                        <p class='card-text'>${ c.description }</p>
                        <button class='btn btn-success  ' id='showClassButton'>Visualizza classe</button>
                    </div>
                </div></center></div>
                `)
                document.getElementById('classes').innerHTML += '</div>'
            }
        })
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