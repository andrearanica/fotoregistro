<!DOCTYPE html>
<html lang='it'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title></title>
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
</head>
<body>
    <div class='footer text-center'>Made with Fotoregistro by Andrea Ranica</div>
    <div class='container text-center my-5'>
        <h1 id='class-name'></h1>
        <p id='students-num'></p>
        <div id='students' class='row my-4'>

        </div>
        <button class='btn btn-primary' id='print' >Stampa il fotoregistro</button>
        <div class='my-2 alert alert-warning' id='warning'>Attenzione: se vuoi salvare il fotoregistro come PDF, seleziona <i>Salva come PDF</i> come destinazione nella finestra che comparirà</div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js' integrity='sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N' crossorigin='anonymous'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
    <script src='./javascript/pdf-script.js'></script>
</body>
</html>
