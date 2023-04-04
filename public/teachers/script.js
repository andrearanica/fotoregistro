let userInfo = {}
let classes = []

function getClasses () {
    $.ajax({
        url: `../../php/getClasses.php?teacher_id=${ userInfo.teacher_id }`,
        type: 'GET',
        dataType: 'json',
        success: data => {
            console.log(data)
            // console.log(`Classi di questo insegnante: ${ data }`)
            document.getElementById('classes').innerHTML = '<div class="row">'
            data.map(c => document.getElementById('classes').innerHTML += `
            <div class="col">
                <center><div class='card my-2' style='width: 18rem; margin: auto; '>
                    <div class='card-body'>
                        <h5 class='card-title'>Classe ${ c.class_name }</h5>
                        <button onclick="showClass('${ c.class_id }')" class='btn btn-success  ' id='showClassButton'>Visualizza classe</button>
                    </div>
                </div></center>
            </div>
            `)
            document.getElementById('classes').innerHTML += '</div>'
        }
    })
}

function createClass (token, className, classAccessType, classSchoolId, teacherId) {
    $.ajax({
        url: '../../php/addNewClass.php',
        type: 'POST',
        dataType: 'json',
        data: {
            token: token,
            className: className,
            classAccessType: classAccessType,
            classSchoolId: classSchoolId,
            teacherId: teacherId
        },
        success: data => {
            console.log(data)
            document.getElementById('newClassAlert').className = 'alert alert-success my-2'
            document.getElementById('newClassAlert').innerHTML = '<b>Classe creata con successo</b>'
            getClasses()
        },
        error: data => {
            console.log(data)
        }
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
        userInfo = data

        document.getElementById('title').innerHTML = 'Benvenuto ' + userInfo.name
        getClasses()
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
    createClass(window.localStorage.getItem('token'), document.getElementById('newClassName').value, document.getElementById('newClassAccessType').value, document.getElementById('newClassSchoolId').value, userInfo.teacher_id)
})

document.getElementById('logoutButton').addEventListener('click', () => {
    window.localStorage.clear()
    window.location.href = '../'
})

function showClass (classId) {
    window.location.href = `./classes.html?id=${ classId }` 

}

document.getElementById('accountInfoForm').addEventListener('submit', event => {
    event.preventDefault()
    $.ajax({
        url: '../../php/updateAccount.php?type=teachers',
        type: 'POST',
        data: {
            name: document.getElementById('accountName').value,
            surname: document.getElementById('accountSurname').value,
            email: document.getElementById('accountEmail'),
            password: document.getElementById('accountPassword')
        },
        success: () => {
            document.getElementById('accountInfoAlert').className = 'alert alert-success'
            document.getElementById('accountInfoAlert').innerHTML = '<b>Credenziali aggiornate correttamente</b>'
        },
        error: () => {
            document.getElementById('accountInfoAlert').className = 'alert alert-danger'
            document.getElementById('accountInfoAlert').innerHTML = '<b>C\'è stato un errore, riprova più tardi'
        }
    })
})