let login = true;

let loginForm  = '<form action="index.php" method="POST"><div class="form-group"><input class="form-control my-1" name="email" placeholder="Email"></div><div class="form-group"><input class="form-control my-1" name="password" my-1" type="password" placeholder="Password"></div><input class="form-control" value="Login" type="submit"></form>'
let signupForm = '<form action="index.php" method="POST"><div class="form-group"><input class="form-control my-1" name="name" placeholder="Nome"></div><div class="form-group"><input class="form-control my-1" name="surname" placeholder="Cognome"></div><div class="form-group"><input class="form-control my-1" name="email" type="email" placeholder="Email"></div><div class="form-group"><input class="form-control my-1" type="password" name="password" placeholder="Password"></div><div class="form-group"><input class="form-control my-1" name="class" placeholder="Classe"></div><input class="form-control my-1" value="Registrati" type="submit"></form>'

if (login) {
    document.getElementById("form").innerHTML = loginForm;
} else {
    document.getElementById("form").innerHTML = signupForm;
}

function changeForm (login) {
    if (login) {
        document.getElementById('form').innerHTML = loginForm;
        document.getElementById('changeForm').innerHTML = 'Non sei registrato?'
    } else {
        document.getElementById("form").innerHTML = signupForm;
        document.getElementById('changeForm').innerHTML = 'Hai già un account?'
    }
}

document.getElementById('changeForm').onclick = () => {
    if (login) login = false 
    else login = true
    changeForm(login)
}