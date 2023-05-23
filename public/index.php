<?php

ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use App\controllers\SiteController;
use App\controllers\AjaxController;
use App\controllers\StudentController;
use App\controllers\TeacherController;
use App\controllers\ClassController;
use App\utilities\Jwt;

$request = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

$siteController    = new SiteController();
$ajaxController    = new AjaxController();
$studentController = new StudentController();
$teacherController = new TeacherController();
$classController   = new ClassController();

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
    case 'info-from-jwt-student':
        $studentController->getInfoFromJwt();
        break;
    case 'info-from-jwt-teacher':
        $teacherController->getInfoFromJwt();
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
        $studentController->enableAccount();
        break;
    case 'enable-account-teacher':
        $teacherController->enableAccount();
        break;
    case 'class':
        $siteController->Class();
        break;
    case 'subscribe-student':
        $studentController->subscribeToClass();
        break;
    case 'subscribe-teacher':
        $teacherController->subscribeToClass();
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
    case 'teacher-signup':
        $teacherController->Signup();
        break;
    case 'teacher-login':
        $teacherController->Login();
        break;
    case 'update-student':
        $studentController->updateStudent();
        break;
    case 'edit-password-student':
        $studentController->editPassword();
        break;
    case 'edit-password-teacher':
        $teacherController->editPassword();
        break;
    case 'update-teacher':
        $teacherController->updateTeacher();
        break;
    case 'new-class':
        $classController->newClass();
        break;
    case 'remove-class':
        $classController->removeClass();
        break;
    case 'unsubscribe-student':
        $studentController->unsubscribeFromClass();
        break;
    case 'unsubscribe-teacher':
        $teacherController->unsubscribeFromClass();
        break;
    case 'remove-image':
        $studentController->removePhoto();
        break;
    case 'teacher-classes':
        $teacherController->getClasses();
        break;
    case 'class-info':
        $classController->getClassFromId();
        break;
    case 'get-students':
        $classController->getStudents();
        break;
    case 'get-teachers':
        $classController->getTeachers();
        break;
    case 'student-info':
        $studentController->getStudentById();
        break;
    case 'print-pdf':
        $classController->printPdf();
        break;
    case 'add-to-blacklist':
        $studentController->addToBlacklist();
        break;
    case 'get-banned-students':
        $classController->getBannedStudents();
        break;
    case 'remove-student-from-blacklist':
        $studentController->removeFromBlacklist();
        break;
    case 'edit-class':
        $classController->editClass();
        break;
    case 'check-token':
        if (Jwt::checkToken(htmlspecialchars($_POST['token']))) {
            echo json_encode( array('message' => 'ok'));
        } else {
            echo json_encode(array('message' => 'error'));
        }
        break;
    default: 
        $siteController->NotFound();
}

?>