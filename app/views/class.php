<!DOCTYPE html>
    
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href=''>
        <style>
            td {
                border: 2px solid black;
            }
            img {
                border-radius: 25px;
            }
            @import url('https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300&display=swap');

body {
    font-family: 'Fira Sans', sans-serif;
}
        </style>
    </head>
    <body>
        <div class='container my-5 text-center'>
            <h1 id='title'></h1>
        
            <p class='my-1'>Per iscriverti a questa classe</p>
            <h4>Scansiona questo QR code</h4><canvas id='canvas'></canvas>
            <p id='class-id'></p>
            <hr>
            <div id='show-students'>
                
            </div>
            <!--<button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#student-info'>${ student.name } ${ student.surname }</button> <br />-->

            <div class="modal fade" id="student-info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title fs-5" id='student-name'></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id='student-image' width='400'>
                            <p id='student-messages'></p>
                            <p id='student-complete-info'></p>
                        </div>
                        <div class="modal-footer">
                            <button id='delete-photo' class='btn btn-warning' style='color: white;'>Cancella questa foto</button>
                            <button id='ban-student' class='btn btn-danger'>Espelli questo studente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src='../node_modules/qrcode/build/qrcode.js'></script>
        <script src="classScript.js"></script>
    </body>
</html>