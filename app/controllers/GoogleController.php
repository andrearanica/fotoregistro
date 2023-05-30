<?php

namespace App\controllers;

use Google;
use App\utilities\Jwt;
use App\models\StudentModel;

class GoogleController {
    private Google\client $googleClient;
    private $code;
    private $studentModel;
    private $teacherModel;

    public function __construct () {
        $this->googleClient = new Google\Client;
        $this->googleClient->setClientId($_ENV['CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV['REDIRECT_URI']);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
        $this->code = $_GET['code'] ?? null;
    }

    public function handleLoginStudent () {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->code);
        $this->googleClient->setAccessToken($token);
        $googleService = new Google\Service\Oauth2($this->googleClient);
        $data = $googleService->userinfo->get();
        // var_dump($data);

        $this->studentModel = new StudentModel();
        $this->studentModel->setId(uniqid('st_'));
        $this->studentModel->setName($data->name);
        $this->studentModel->setSurname('Rota');
        $this->studentModel->setEmail($data->email);
        $this->studentModel->setPassword('google');
        $this->studentModel->setEnabled(true);
        $this->studentModel->setActivationCode(uniqid());        

        $headers = array('alg' => 'HS256', 'typ' => 'JWT');
        $payload = array('id' => $this->studentModel->getId(), 'name' => $this->studentModel->getName(), 'surname' => '', 'email' => $this->studentModel->getEmail());
        $jwt = Jwt::createToken($headers, $payload);

        echo $jwt;
        echo "<script>window.localStorage.setItem('token', '$jwt')</script>";

        $this->studentModel->addStudent();
        
        echo "<a href='student'>Continua</a>";
    }
    public function getUrl(): string
    {
        return $this->googleClient->createAuthUrl();
    }
}

?>