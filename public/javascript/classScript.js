let classInfo = {}
let id = ''

let studentsDiv = document.getElementById('show-students')

if (window.location.href.includes('?id')) {
    id = window.location.href.split('=')[1]
} else {
    window.location.href = '/teachers'
}

$.ajax({
    url: 'check-token',
    type: 'POST',
    data: {
        token: window.localStorage.getItem('token')
    },
    dataType: 'json',
    success: data => {
        if (data.message === 'error') {
            window.location.href = '../public'
        }
    },
    error: data => {
        console.log(data)
    }
})

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

        try {
            console.log(user.teacher_id)
        } catch (exception) {
            window.location.href = '../public'
        }

        // Fill account form
        document.getElementById('account-name').value = user.name
        document.getElementById('account-surname').value = user.surname
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
        if (classInfo === undefined) {
            window.location.href = 'teacher'
        }
        document.getElementById('title').innerHTML = `Classe ${ classInfo.class_name }`
        document.getElementById('class-id').innerHTML = `Oppure inserisci questo codice: ${ classInfo.class_id }`
        document.getElementById('pdf-id').value = classInfo.class_id
        new QRCode(document.getElementById('canvas'), classInfo.class_id)
    },
    error: data => {
        console.log(data)
    }
})

$.ajax({
    url: 'get-teachers',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        class_id: id
    },
    success: data => {
        for (let i = 0; i < data.length; i++) {
            document.getElementById('show-teachers').innerHTML += `${ data[i].name } ${ data[i].surname }`
            if (i !== data.length - 1) {
                document.getElementById('show-teachers').innerHTML += ', '
            }
        }
    },
    error: data => {
        console.log(data)
    }
})

function getStudents () {
    studentsDiv.innerHTML = ''
    studentsDiv.className = 'text-center'
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
}

getStudents()

function removeFromBlacklist (student_id) {
    $.ajax({
        url: 'remove-student-from-blacklist',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            student_id: student_id,
            class_id: classInfo.class_id
        },
        success: data => {
            showBannedStudents()
        },
        error: data => {
            console.log(data)
        }
    })
}

function showBannedStudents () {
    document.getElementById('banned-students-div').innerHTML = ''
    $.ajax({
        // document.getElementById('title').innerHTML = 'ciao'
        url: 'get-banned-students',
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
            console.log(data)
            if (data.length > 0) {
                data.map(student => {
                    if (student.photo) {
                        document.getElementById('banned-students-div').innerHTML += `
                            <div class="col-sm">
                                <img width='200' src="../app/photos/${ student.student_id }.${ student.photo_type }"><br>
                                <button onclick='removeFromBlacklist("${ student.student_id }")' class='btn btn-success my-2'>${ student.name } ${ student.surname }</button>
                            </div>
                        `
                    } else {
                            document.getElementById('banned-students-div').innerHTML += `
                            <div class="col-sm">
                                <img width='200' src="../app/photos/user.png"><br>
                                <button onclick='removeFromBlacklist("${ student.student_id }")' class='btn btn-success my-2'>${ student.name } ${ student.surname }</button>
                            </div>
                        `
                    }
                })
            } else {
                document.getElementById('banned-students-div').innerHTML = 'Non è stato bannato nessuno studente in questa classe'
            }
        },
        error: data => {
            console.log(data)
        }
    })
}

document.getElementById('show-banned-students-btn').addEventListener('click', () => {
    showBannedStudents()
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
            document.getElementById('eject-student').onclick = () => {
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
                        getStudents()
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

                        showStudents(getStudents())
                    }
                })
            }
            document.getElementById('ban-student').onclick = () => {
                $.ajax({
                    url: 'add-to-blacklist',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
                    },
                    data: {
                        student_id: student.student_id,
                        class_id: student.class_id
                    },
                    success: data => {
                        showStudents(getStudents())
                    }
                })
            }
        },
        error: data => {
            console.log(data)
        }
    })
}

document.getElementById('reload-students-info').addEventListener('click', (e) => {
    showStudents(getStudents())
})

document.getElementById('account-info-form').addEventListener('submit', (e) => {
    e.preventDefault()
    document.getElementById('account-alert').className = ''
    document.getElementById('account-alert').innerHTML = ''
    $.ajax({
        url: 'update-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        dataType: 'json',
        data: {
            type: 'teachers',
            name: document.getElementById('account-name').value,
            surname: document.getElementById('account-surname').value,
            email: user.email
        },
        success: data => {
            if (data.message == 'ok') {
                document.getElementById('account-alert').className = 'alert alert-success my-2'
                document.getElementById('account-alert').innerHTML = '<b>Account modificato</b>'
            } else {
                document.getElementById('account-alert').className = 'alert alert-danger my-2'
                document.getElementById('account-alert').innerHTML = '<b>Qualcosa è andato storto</b>'
            }
        },
        error: data => {
            console.log(data)
        }
    })
})

document.getElementById('account-password-form').addEventListener('submit', (e) => {
    e.preventDefault()
    if (document.getElementById('new-password').value !== document.getElementById('confirm-new-password').value) {
        document.getElementById('account-alert').className = 'alert alert-danger'
        document.getElementById('account-alert').innerHTML = '<b>Le password inserite non combaciano</b>'
        return
    }
    $.ajax({
        url: 'edit-password-teacher',
        type: 'POST',
        headers: {
            Authorization: `Bearer ${ window.localStorage.getItem('token') }`
        },
        data: {
            email: user.email,
            password: document.getElementById('new-password').value
        },
        dataType: 'json',
        success: data => {
            if (data.message == 'ok') {
                document.getElementById('account-alert').className = 'alert alert-success'
                document.getElementById('account-alert').innerHTML = '<b>Password aggiornata con successo</b>'
            } else {
                document.getElementById('account-alert').className = 'alert alert-danger'
                document.getElementById('account-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
            }
        },
        error: data => {
            document.getElementById('account-alert').className = 'alert alert-danger'
            document.getElementById('account-alert').innerHTML = '<b>C\'è stato un errore, riprova più tardi</b>'
        }
    })
})