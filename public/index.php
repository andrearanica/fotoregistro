<?php

ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use App\controllers\SiteController;
use App\controllers\AjaxController;
use App\controllers\StudentController;
use App\controllers\TeacherController;
use App\controllers\ClassController;

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
    case 'student-info':
        $studentController->getStudentById();
        break;
    default: 
        $siteController->NotFound();
}

?>