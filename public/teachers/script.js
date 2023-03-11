let userInfo = {}
let classes = []

document.onload = () => {
    $.ajax({
        
    })
}

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
                        <button onclick="showClass('${ c.class_id }')" class='btn btn-success  ' id='showClassButton'>Visualizza classe</button>
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
    url: '../../php/getSchools.php',
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
            document.getElementById('newClassAlert').className = 'alert alert-success my-2'
            document.getElementById('newClassAlert').innerHTML = '<b>Classe creata con successo</b>'
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('logoutButton').addEventListener('click', () => {
    window.localStorage.clear()
    window.location.href = '../'
})

function showClass (classId) {
    window.location.href = `./classes.html?id=${ classId }` 

}