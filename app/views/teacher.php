<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Dashboard Insegnanti</title>
        <meta name='description' content=''>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='../style.css'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300&display=swap');

            body {
                font-family: 'Fira Sans', sans-serif;
            }
        </style>
    </head>
    <body>
        <?php require('../app/views/components/navbar.php'); ?>
        <?php require('../app/views/components/account-info.php'); ?>
        <div class='container my-5 text-center'>
            <!--<button type='button' class='btn' data-bs-toggle='modal' data-bs-target='#accountInfoModal'>
                Il mio account
            </button>-->
            <div class='modal fade' id='accountInfoModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='exampleModalLabel'>Il mio account</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>              
                    <div class='modal-body'>
                        <form id='accountInfoForm'>
                            <input class='form-control my-2' id='accountName' placeholder='Nome'>
                            <input class='form-control my-2' id='accountSurname' placeholder='Cognome'>
                            <input class='form-control my-2' id='accountEmail' type='email' placeholder='Email'>
                            <input class='form-control my-2' id='accountPassword' type='password' placeholder='Password'>
                            <input class='btn btn-success' type='submit' value='Aggiorna'>
                            <div id='accountInfoAlert'>

                            </div>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
            <!--<button class='btn' id='logoutButton'>Logout</button>-->
            <h1 id='title'></h1>
            <div id='classes' class='container text-center my-5 row'>
                
            </div>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#newClassModal'>
                Nuova classe
            </button><br><br>
            <a class='btn btn-primary' data-bs-toggle='collapse' href='#subscribe' role='button' aria-expanded='false' aria-controls='subscribe'>
                Aggiungi una classe già esistente
            </a>
            <div class='collapse' id='subscribe'>
                <div class='card card-body my-2'>
                    <!--bela-->
                    <form id='subscribe-form'>
                        <label for='subscribe-class-id'>ID della classe</label>
                        <input id='subscribe-class-id' class='form-control my-2 text-center'>
                        <input type='submit' value='Aggiungi' class='btn btn-primary my-2'>
                    </form>
                    <div id='subscribe-alert'>
                        
                    </div>
                </div>
            </div>
            <div id='message-div'>

            </div>
            <div class='modal fade' id='newClassModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h1 class='modal-title fs-5' id='exampleModalLabel'>Nuova classe</h1>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form id='newClassForm'>
                            <input id='newClassName'        class='form-control my-2' name='newClassName'        placeholder='Nome (es. 5ID)' required>
                            <input class='btn' type='submit' value='Crea classe'>
                            <div id='newClassAlert'></div>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
        <script src='./javascript/teacherScript.js'></script>
    </body>
</html>