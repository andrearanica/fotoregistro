<!DOCTYPE html>
    
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title></title>
        <meta name='description' content=''>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href=''>
        <style>
            td {
                border: 2px solid black;
            }
            img {
                border-radius: 5px;
            }
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
            <h1 id='title'></h1>
            <a class='btn btn-primary my-4' data-bs-toggle='collapse' href='#class-info' role='button' aria-expanded='false' aria-controls='collapseExample'>
                Come entrare in questa classe?
            </a>
            <div class='collapse' id='class-info'>
                <div class='card card-body my-2'>
                    <p class='my-1'>Per iscriverti a questa classe</p>
                    <h4>Scansiona questo QR code</h4><br>
                    <center><div id='canvas'></div></center><br>
                    <p id='class-id'></p>
                </div>
                <hr>
            </div>
            <div id='show-students'>
                
            </div>
            <hr>
            <?php require('../app/views/components/show-banned-students.php'); ?>
            <button class='btn btn-primary my-2' data-bs-toggle='modal' data-bs-target='#exampleModal'>Stampa PDF</button>
            <!--<button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#student-info'>${ student.name } ${ student.surname }</button> <br />-->

            <div class='modal fade' id='student-info' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4 class='modal-title fs-5' id='student-name'></h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <img id='student-image' width='400'>
                            <p id='student-messages'></p>
                            <p id='student-complete-info'></p>
                        </div>
                        <div class='modal-footer'>
                            <button id='delete-photo' class='btn btn-warning' style='color: white;'>Cancella questa foto</button>
                            <button id='eject-student' class='btn btn-danger'>Espelli questo studente</button>
                            <button id='ban-student' class='btn btn-dark'>Banna lo studente</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Stampa PDF</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form id='pdf-form' action='print-pdf'>
                            <input name='id' id='pdf-id' style='display: none;'>
                            <label for='display'>Seleziona gli studenti da mostrare nel PDF</label>
                            <select required id='display' name='display' class='form-control my-2 text-center'>
                                <option value='all'>Tutti gli studenti iscritti alla classe</option>
                                <option value='photo'>Solo gli studenti che hanno caricato la foto</option>
                            </select>
                            <input type='submit' class='btn btn-success'>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
        <script src='./javascript/classScript.js'></script>
        <script src='https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js'></script>
    </body>
</html>