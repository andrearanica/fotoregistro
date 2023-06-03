<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Dashboard Studente</title>
        <meta name='description' content=''>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta charset='UTF-8'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300&display=swap');

            body {
                font-family: 'Fira Sans', sans-serif;
            }
            #canvas {
                border: 2px solid black;
            }
        </style>
    </head>
    <body id='body'>
        <?php require('../app/views/components/navbar.php'); ?>
        <?php require('../app/views/components/account-info.php'); ?>
        <div class='container my-5 text-center'>
            <h1 id='title'></h1>
            <div id='user-alert'>
                
            </div>
            <center>
            <div id='class-info' class='table'>

            </div>
            </center>
            <button id='unsubscribe' class='btn btn-danger' style='display: none;'>Disiscriviti dalla classe</button>
            
            <div id='subscribe-form'>
                <a class='btn btn-primary' data-bs-toggle='collapse' href='#reader' role='button' aria-expanded='false' aria-controls='collapseExample'>Scansiona QR code</a>
                <div class='collapse' id='reader' width='600px'>

                </div>
                <a class='btn btn-primary' data-bs-toggle='collapse' href='#subscribe-to-class' role='button' aria-expanded='false' aria-controls='collapseExample'>Iscriviti con codice</a>
                <form id='subscribe-to-class' class='collapse'>
                    <input id='class-id' class='form-control my-2 text-center'>
                    <input type='submit' class='btn' value='Iscriviti'>
                </form>
                <div id='subscribe-errors'>

                </div>
            </div>

            <hr class='my-4'>
            
            <img id='student-photo' width='400'>
            <div id='messages' class='my-4'>

            </div>
            <!--<button id='start-camera' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#photo-modal'>Scatta la foto</button>-->
            <div class='modal fade' id='photo-modal' tabindex='-1' aria-labelledby='photo-modal' aria-hidden='true'>
                <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='exampleModalLabel'>Scatta la foto</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <form id='photo-form' action='../../php/upload.php' method='post' enctype='multipart/form-data'>
                            <video id='video' width='320' height='240' autoplay></video>
                        
                            <!--<div class='text-center'>Risultato</div>-->
                            <canvas id='canvas' width='320' height='240' style='display: none'>Scatta la foto...</canvas>
                            <input id='student-id-1' style='display: none' name='student_id'>
                            <!--<input id='file-upload' type='file' name='file'>
                            <input class='btn' name='upload' type='submit'>-->
                        </form>
                    </div>
                    <div class='modal-footer'>
                        <button id='try-again-photo' class='btn' style='display: none'>Riprova</button>
                        <button id='click-photo' class='btn btn-success'>Scatta</button>
                        <button id='save-photo' class='btn' style='display: none'>Salva</button>
                    </div>
                </div>
                </div>
            </div>
            <button id='upload-photo' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#upload-modal'>Carica la foto da file</button>
            
            <div class='modal fade' id='upload-modal' tabindex='-1' aria-labelledby='photo-modal' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Carica la foto</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <form action='upload-photo' method='POST' enctype='multipart/form-data'>
                                <input name='file' type='file'>
                                <input id='student-id-2' style='display: none' name='student_id'>
                                <input type='submit' class='btn btn-success'>
                            </form>  
                        </div>
                        <div class='modal-footer'>
                            
                        </div>
                    </div>
                </div>
            </div><br>
            
            <div class='modal fade' id='accountInfo' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Il tuo account</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <form id='account-info-form'>
                                <label for='account-name'>Nome</label>
                                <input id='account-name' class='form-control my-2 text-center'>
                                <label for='account-surname'>Cognome</label>
                                <input id='account-surname' class='form-control my-2 text-center'>
                                <label for='account-email'>Email</label>
                                <input id='account-email' class='form-control my-2 text-center' readonly>
                                <label for='account-password'>Password</label>
                                <input id='account-password' class='form-control my-2 text-center' type='password'>
                                <label for='account-password-confirm'>Conferma password</label>
                                <input id='account-password-confirm' class='form-control my-2 text-center' type='password'>
                                <input type='button' id='reset-account-info' class='btn btn-secondary' value='Reset'>
                                <input type='submit' value='Modifica' class='btn btn-success'>
                            </form>
                            <div id='account-alert'>

                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>        
        
        <script src='./javascript/student-script.js' type='module'></script>
        <script src='https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js' integrity='sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N' crossorigin='anonymous'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
        <script src='./javascript/html5-qrcode.min.js'></script>
        <script src='./javascript/check-token.js'></script>
    </body>
</html>