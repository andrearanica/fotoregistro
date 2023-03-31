let classInfo = {}
let id = ''

if (window.location.href.includes('?id')) {
    id = window.location.href.split('=')[1]
} else {
    window.location.href = '../teachers'
}

$.ajax({
    // document.getElementById('title').innerHTML = 'ciao'
    url: '../../php/getClasses.php',
    type: 'GET',
    dataType: 'json',
    data: {
        classId: id
    },
    success: (data) => {
        classInfo = data[0]
        console.log(classInfo)
        document.getElementById('title').innerHTML = `Classe ${ classInfo.class_name }`
        let canvas = document.getElementById('canvas')
        QRCode.toCanvas(canvas, id, (error) => {
            if (error) {
                console.log(error)
            }
        })
    }
})