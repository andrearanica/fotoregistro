<?php

use App\models\ClassModel;
$classModel = new ClassModel();

$classModel->setId($_GET['id']);
$classModel->getClassFromId();

?>
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
                background-color: white;
                padding: 15px;
            }
        </style>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
    </head>
    <body>
        <div class='footer text-center'>Made with Fotoregistro</div>
        <h1 id='class-name' class='text-center my-4'>Classe <?= $classModel->getName() ?></h1>
        <div class='container text-center'>
            <p id='students-num'></p>
            <div id='students' class='row my-4 text-center'>
                <?php

                foreach ($classModel->getStudents() as $student) {
                    $name = $student['name']; $surname = $student['surname']; $img = '../app/photos/' . $student['student_id'] . '.' . $student['photo_type']; $photo = $student['photo'];
                    $card_with_photo = "
                    <div class='col col-lg my-2 mx-1' style='width: 18rem;'>
                        <img style='max-height: 100px; width: auto;' src='$img'>
                        <div class='card-body'>
                            <h5 style='font-size: 90%;' class='card-title my-2'>$name $surname</h5>
                        </div>
                    </div>
                    ";
                    $card_without_photo = "
                    <div class='col col-lg my-2 mx-1' style='width: 18rem;'>
                        <img style='max-height: 120px; width: auto;' src='../app/photos/user.png'>
                        <div class='card-body'>
                            <h5 style='font-size: 90%;' class='card-title my-2'>$name $surname</h5>
                        </div>
                    </div>
                    ";
                    //
                    echo ($photo) ? "$card_with_photo" : (($_GET['display'] == 'all') ? "$card_without_photo" : null);
                }

                ?>
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js' integrity='sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N' crossorigin='anonymous'></script>
        <script>
            print()
        </script>
    </body>
</html>
