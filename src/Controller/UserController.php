<?php

namespace Controller;

use Model\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController extends BaseController
{
    public function getRegistrate()
    {
        require_once '../Views/registration_form.php';
    }
    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }
    public function getProfile()
    {
        require_once '../Views/profile_page.php';
    }
    public function getEditProfile()
    {
        require_once '../Views/edit_profile_form.php';
    }
    private User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    //Регистрация
    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);
            $this->userModel->addUser($request->getName(), $request->getEmail(), $password, $request->getPhoto());
            header('Location: /catalog');
            exit();
        }
        require_once '../Views/registration_form.php';
    }
    public function login(LoginRequest $request)
    {
        $errors = $request->validate();
        // если нет ошибок, подключаемся к БД
        if (empty($errors)) {

            $result = $this->authService->auth($request->getUsername(), $request->getPassword());

            if ($result) {
                header("Location: catalog");
                exit();

            } else {
                $errors['username'] = "Логин или пароль указаны неверно!";
            }
        }
        require_once '../Views/login_form.php';
    }
    //выдача профиля
    public function profile()
    {
        if (!$this->authService->check()) {
            header("Location: login");
            exit();
        } else {
            $user = $this->authService->getCurrentUser();
            require_once '../Views/profile_page.php';
        }
    }
// изменение данных на странице профиля
    public function editProfile(EditProfileRequest $request)
    {
        if (!$this->authService->check()) {
            header('Location: login');
            exit;
        }
        $user = $this->authService->getCurrentUser();
        $errors = $request->validate();

        if (empty($errors)) {

            $user = $this->userModel->verification($user->getId());

            if ($user->getName() !== $request->getName()) {
                $this->userModel->updateNamedByID($request->getName(), $user->getId());
            }
            if ($user->getEmail() !== $request->getEmail()) {
                $this->userModel->updateEmailByID($request->getEmail(), $user->getId());
            }
            header('Location: profile');
            exit;
        }
        require_once '../Views/edit_profile_form.php';
    }
    public function logout()
    {
        $this->authService->logout();
        header('Location: login');
    }
}