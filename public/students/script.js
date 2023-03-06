$.ajax({
    url: '../../php/jwt.php?type=students',
    type: 'POST',
    dataType: 'json',
    data: {
        token: window.localStorage.getItem('token')
    },
    success: (data) => {
        console.log(data)
    },
    error: (data) => {
        console.error(data)
    }
})