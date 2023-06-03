<?php

ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use Dotenv\Dotenv;
use App\utilities\Jwt;
use App\controllers\AjaxController;
use App\controllers\SiteController;
use App\controllers\ClassController;
use App\controllers\GoogleController;
use App\controllers\StudentController;
use App\controllers\TeacherController;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$request = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

$siteController    = new SiteController();
$studentController = new StudentController();
$teacherController = new TeacherController();
$classController   = new ClassController();
$googleControllerStudent = new GoogleController(1);
$googleControllerTeacher = new GoogleController(2);

switch ($request) {
    case '':
        $siteController->HomePage();
        break;
    case 'login':
        $siteController->LoginAndSignup();
        break;
    case 'student':
        $siteController->StudentDashboard();
        break;
    case 'teacher':
        $siteController->TeacherDashboard();
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
        $siteController->PDF();
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
    case 'google-student':
        $googleControllerStudent->handleLoginStudent();
        break;
    case 'google-teacher':
        $googleControllerTeacher->handleLoginTeacher();
        break;
    default: 
        $siteController->NotFound();
}

?>