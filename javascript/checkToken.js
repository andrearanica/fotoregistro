if (window.localStorage.getItem('token') == '') {
    window.location.href = '../'
} else {
    $.ajax({
        url: '../../php/jwt.php',
        dataType: 'json',
        data: {
            check: window.localStorage.getItem('token')
        },
        success: (data) => {
            if (!data.valid) {
                window.location.href = '../'
            }
        }
    })
}