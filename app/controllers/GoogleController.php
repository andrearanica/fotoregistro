<?php

namespace App\controllers;

use Google;
use App\utilities\Jwt;
use App\models\StudentModel;
use App\models\TeacherModel;

class GoogleController {
    private Google\client $googleClient;
    private $code;
    private $studentModel;
    private $teacherModel;
    private $type;

    public function __construct (int $type) {
        $this->googleClient = new Google\Client();
        $this->googleClient->setClientId($_ENV['CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV["REDIRECT_URI_$type"]);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
        $this->code = $_GET['code'] ?? null;
        $this->type = $type;
    }

    public function handleLoginStudent () {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->code);
        $this->googleClient->setAccessToken($token);
        $googleService = new Google\Service\Oauth2($this->googleClient);
        $data = $googleService->userinfo->get();
        // var_dump($data);

        $this->studentModel = new StudentModel();
        
        $this->studentModel->setEmail($data->email);

        if (!$this->studentModel->checkMail()) {
            $this->studentModel->setId(uniqid('st_'));
            $this->studentModel->setName(explode(' ', $data->name)[0]);
            $this->studentModel->setSurname(explode(' ', $data->name)[1]); 
            $this->studentModel->setPassword('');
            $this->studentModel->setEnabled(true);
            $this->studentModel->setActivationCode(uniqid());        
    
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('id' => $this->studentModel->getId(), 'name' => $this->studentModel->getName(), 'surname' => '', 'email' => $this->studentModel->getEmail());
            $jwt = Jwt::createToken($headers, $payload);

            echo "<script>window.localStorage.setItem('token', '$jwt')</script>";

            $this->studentModel->addStudentWithGoogle();
        } else {
            $this->studentModel->getStudentByEmailWithGoogle();
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('id' => $this->studentModel->getId(), 'name' => $this->studentModel->getName(), 'surname' => '', 'email' => $this->studentModel->getEmail());
            $jwt = Jwt::createToken($headers, $payload);

            echo "<script>window.localStorage.setItem('token', '$jwt')</script>";
        }

        // echo $jwt;
        
        echo '<script>window.location.href="student"</script>';
    }

    public function handleLoginTeacher () {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->code);
        $this->googleClient->setAccessToken($token);
        $googleService = new Google\Service\Oauth2($this->googleClient);
        $data = $googleService->userinfo->get();
        // var_dump($data);

        $this->teacherModel = new TeacherModel();
        
        $this->teacherModel->setEmail($data->email);

        if (!$this->teacherModel->checkMail()) {
            $this->teacherModel->setId(uniqid('tc_'));
            $this->teacherModel->setName(explode(' ', $data->name)[0]);
            $this->teacherModel->setSurname(explode(' ', $data->name)[1]); 
            $this->teacherModel->setPassword('');
            $this->teacherModel->setEnabled(true);
            $this->teacherModel->setActivationCode(uniqid());        
    
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('id' => $this->teacherModel->getId(), 'name' => $this->teacherModel->getName(), 'surname' => '', 'email' => $this->teacherModel->getEmail());
            $jwt = Jwt::createToken($headers, $payload);

            echo "<script>window.localStorage.setItem('token', '$jwt')</script>";

            $this->teacherModel->addTeacherWithGoogle();
        } else {
            echo $this->teacherModel->getTeacherByEmailWithGoogle();
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('id' => $this->teacherModel->getId(), 'name' => $this->teacherModel->getName(), 'surname' => '', 'email' => $this->teacherModel->getEmail());
            $jwt = Jwt::createToken($headers, $payload);

            echo "<script>window.localStorage.setItem('token', '$jwt')</script>";
        }

        // echo $jwt;
        
        echo '<script>window.location.href="teacher"</script>';
    }

    public function getUrl(): string {
        return $this->googleClient->createAuthUrl();
    }
}

?>