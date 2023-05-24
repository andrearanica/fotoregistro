$.ajax({
    url: 'check-token',
    type: 'POST',
    data: {
        token: window.localStorage.getItem('token')
    },
    dataType: 'json',
    success: data => {
        if (data.message === 'error') {
            window.location.href = '../public/login'
        }
    },
    error: data => {
        window.location.href = '../public/login'
    }
})

$.ajax({
    url: 'class-info',
    type: 'POST',
    headers: {
        Authorization: `Bearer ${ window.localStorage.getItem('token') }`
    },
    dataType: 'json',
    data: {
        class_id: new URLSearchParams(window.location.search).get('id')
    },
    success: data => {
        console.log(data)
        document.getElementById('class-name').innerHTML = `Classe ${ data[0].class_name }`

        $.ajax({
            url: 'get-students',
            type: 'POST',
            headers: {
                Authorization: `Bearer ${ window.localStorage.getItem('token') }`
            },
            dataType: 'json',
            data: {
                class_id: new URLSearchParams(window.location.search).get('id')
            },
            success: data => {
                console.log(data)
                document.getElementById('students-num').innerHTML = `Numero di studenti: ${ data.length }`
                if (new URLSearchParams(window.location.search).get('display') == 'all') {
                    data.map(student => document.getElementById('students').innerHTML += `
                    <div class='col col-lg my-2' style='width: 18rem;'>
                        <img style='max-height: 150px; width: auto;' src='../app/photos/${ student.photo ? `${student.student_id}.${ student.photo_type }` : 'user.png' }' class='card-img-top'>
                        <div class='card-body'>
                            <h5 class='card-title my-2'>${ student.name } ${ student.surname }</h5>
                        </div>
                    </div>
                    `)
                } else {
                    data.map(student => {
                        if (student.photo) {
                            document.getElementById('students').innerHTML += `
                            <div class='col col-lg my-2' style='width: 18rem;'>
                                <img style='max-height: 150px; width: auto;' src='../app/photos/${ student.student_id }.${ student.photo_type }' class='card-img-top'>
                                <div class='card-body'>
                                    <p class='card-title my-2'>${ student.name } ${ student.surname }</p>
                                </div>
                            </div>
                        `}
                    })
                }
                
                // window.print()
            }
        })


    }
})

document.getElementById('print').addEventListener('click', () => {
    document.getElementById('print').style = 'display: none;'
    document.getElementById('warning').style = 'display: none;'
    print()
    document.getElementById('print').style = ''
    document.getElementById('warning').style = ''
})