<?php

ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
use App\controllers\SiteController;
use App\controllers\AjaxController;

$request = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

$siteController = new SiteController();
$ajaxController = new AjaxController();

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
        $siteController->UploadPhoto();
        break;
    case 'enable-account':
        $siteController->EnableAccount();
        break;
    default: 
        $siteController->NotFound();
}

?>