<?php

ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use App\controllers\SiteController;
use App\controllers\AjaxController;
use App\controllers\StudentController;

$request = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

$siteController    = new SiteController();
$ajaxController    = new AjaxController();
$studentController = new StudentController();

switch ($request) {
    case '':
        $siteController->LoginAndSignup();
        break;
    case 'student':
        $siteController->StudentDashboard();
        break;
    case 'teacher':
        $siteController->TeacherDashboard();
        break;
    case 'ajax':
        $ajaxController->HandleRequest();
        break;
    case 'upload-photo':
        $studentController->UploadPhoto();
        break;
    case 'save-photo':
        $studentController->savePhoto();
        break;
    case 'remove-photo':
        $studentController->removePhoto();
        break;
    case 'enable-account-student':
        $studentController->EnableAccount();
        break;
    case 'class':
        $siteController->Class();
        break;
    case 'subscribe-student':
        $studentController->subscribeToClass();
        break;
    case 'unsubscribe':
        $studentController->unsubscribeFromClass();
        break;
    case 'student-signup':
        $studentController->Signup();
        break;
    case 'student-login':
        $studentController->Login();
        break;
    case 'update-student':
        $studentController->updateStudent();
        break;
    default: 
        $siteController->NotFound();
}

?>