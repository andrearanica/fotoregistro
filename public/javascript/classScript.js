let classInfo = {}
let id = ''

let studentsDiv = document.getElementById('show-students')

if (window.location.href.includes('?id')) {
    id = window.location.href.split('=')[1]
} else {
    window.location.href = '/teachers'
}

$.ajax({
    url: 'ajax?request=infoFromJwt&type=teachers',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
        user = data
        console.log(user)

        // Fill account form
        document.getElementById('account-name').value = user.name
        document.getElementById('account-surname').value = user.surname
        document.getElementById('account-email').value = user.email
    },
    error: (data) => {
        console.log(data)
    }
})

$.ajax({
    // document.getElementById('title').innerHTML = 'ciao'
    url: 'class-info',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        class_id: id
    },
    success: (data) => {
        classInfo = data[0]
        console.log(classInfo)
        document.getElementById('title').innerHTML = `Classe ${ classInfo.class_name }`
        document.getElementById('class-id').innerHTML = `Oppure inserisci questo codice: ${ classInfo.class_id }`
        document.getElementById('pdf-id').value = classInfo.class_id
        let canvas = document.getElementById('canvas')
        QRCode.toCanvas(canvas, id, (error) => {
            if (error) {
                console.log(error)
            }
        })
    },
    error: data => {
        console.log(data)
    }
})

$.ajax({
    // document.getElementById('title').innerHTML = 'ciao'
    url: 'get-students',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        class_id: id,
        students: true
    },
    success: data => {
        showStudents(data)
    },
    error: data => {
        console.log(data)
    }
})

function showStudents (students) {
    if (students.length == 0) {
        studentsDiv.innerHTML += 'Nessuno studente è iscritto a questa classe'
        return
    }
    
    studentsDiv.className = 'row'
    studentsDiv.innerHTML = '<h2>Studenti iscritti</h2>'

    for (let i = 0; i < students.length; i++) {
        console.log(students[i])
        if (students[i].photo) {
            studentsDiv.innerHTML += `
                <div class="col-sm">
                    <img width='200' src="../app/photos/${ students[i].student_id }.${ students[i].photo_type }"><br>
                    <button onclick="showStudentInfo('${ students[i].student_id }')" class="btn my-2" data-bs-toggle='modal' data-bs-target='#student-info'>${ students[i].name } ${ students[i].surname }</button>
                </div>
            `
        } else {
            studentsDiv.innerHTML += `
                <div class="col-sm">
                    <img width='200' src="../app/photos/user.png"><br>
                    <button onclick="showStudentInfo('${ students[i].student_id }')" class="btn my-2" data-bs-toggle='modal' data-bs-target='#student-info'>${ students[i].name } ${ students[i].surname }</button>
                </div>
            `
        }
    }
}

function showStudentInfo (id) {
    $.ajax({
        url: 'student-info',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            student_id: id
        },
        success: student => {
            const student_id = student.student_id
            document.getElementById('student-name').innerHTML = `${ student.name } ${ student.surname }`
            document.getElementById('student-messages').innerHTML = ''
            document.getElementById('student-complete-info').innerHTML = `
            Nome: ${ student.name }<br>
            Cognome: ${ student.surname }<br>
            Email: <a href='mailto:${ student.email }'>${ student.email }</a><br>
            `
            if (student.photo) {
                document.getElementById('student-image').src = `../app/photos/${ student.student_id }.${ student.photo_type }`
                document.getElementById('delete-photo').style = 'color: white;';
            } else {
                document.getElementById('student-image').src = ``
                document.getElementById('student-image').src = ``
                document.getElementById('student-messages').innerHTML = `${ student.name } non ha ancora caricato la sua foto`
                document.getElementById('delete-photo').style = 'display: none;';
            }
            document.getElementById('ban-student').onclick = () => {
                $.ajax({
                    url: 'unsubscribe',
                    type: 'POST',
                    headers: {
                        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                    },
                    data: {
                        student_id: student.student_id
                    },
                    success: () => {
                        location.reload()
                    }
                })
            }
            document.getElementById('delete-photo').onclick = () => {
                $.ajax({
                    url: 'remove-image',
                    type: 'POST',
                    headers: {
                        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                    },
                    data: {
                        student_id: student.student_id
                    },
                    success: () => {
                        document.getElementById('student-image').src = ''
                        document.getElementById('student-messages').innerHTML = 'Foto eliminata'
                        document.getElementById('delete-photo').style = 'display: none;';
                    }
                })
            }
        },
        error: data => {
            console.log(data)
        }
    })
}