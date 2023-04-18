let classInfo = {}
let id = ''

let studentsDiv = document.getElementById('show-students')

if (window.location.href.includes('?id')) {
    id = window.location.href.split('=')[1]
} else {
    window.location.href = '../teachers'
}

$.ajax({
    // document.getElementById('title').innerHTML = 'ciao'
    url: '../../php/getClasses.php',
    type: 'GET',
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
    url: '../../php/getClasses.php?students',
    type: 'GET',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        class_id: id
    },
    success: data => {
        showStudents(data)
    },
    error: data => {
        console.log(data)
    }
})

function showStudents (students) {
    studentsDiv.innerHTML = '<h2>Studenti iscritti</h2>'
    if (students.length == 0) {
        studentsDiv.innerHTML += 'Nessuno studente è iscritto a questa classe'
        return
    }
    students.map(student => {
        studentsDiv.innerHTML += `
        <button class='btn' student-info-button my-2' onclick="showStudentInfo('${ student.student_id }')" data-bs-toggle='modal' data-bs-target='#student-info'>${ student.name } ${ student.surname }</button><br>
        `
    })
}

function showStudentInfo (id) {
    $.ajax({
        url: '../../php/getStudentInfo.php',
        type: 'GET',
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
                document.getElementById('student-image').src = `../../photos/${ student.student_id }.png`
                document.getElementById('delete-photo').style = 'color: white;';
            } else {
                document.getElementById('student-image').src = ``
                document.getElementById('student-image').src = ``
                document.getElementById('student-messages').innerHTML = `${ student.name } non ha ancora caricato la sua foto`
                document.getElementById('delete-photo').style = 'display: none;';
            }
            document.getElementById('ban-student').onclick = () => {
                $.ajax({
                    url: '../../php/unsubscribe.php',
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
                    url: '../../php/upload.php?remove',
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