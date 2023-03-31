$.ajax({
    url: '../../php/getStudentInfo.php',
    type: 'GET',
    dataType: 'json',
    data: {
        student_id: window.location.href.split('=')[1]
    },
    success: data => {
        document.getElementById('student-name').innerHTML = `${ data.name } ${ data.surname }<br />`
        document.getElementById('student-photo').src = `../../photos/${ data.student_id }.jpeg`
    },
    error: data => {
        console.log(data)
    }
})