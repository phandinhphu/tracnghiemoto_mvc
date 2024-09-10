<?php
class Auth extends Controller
{
    private mixed $authModel;
    private mixed $examModel;
    private array $data = [];

    public function __construct()
    {
        $this->authModel = $this->model('AuthModel');
        $this->examModel = $this->model('ExamModel');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('location: ' . WEB_ROOT . '/trang-chu');
    }

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('location: ' . WEB_ROOT . '/trang-chu');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dataReq = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];

            $loggedInUser = $this->authModel->login($dataReq['email'], $dataReq['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                if (!$this->authModel->getUser($dataReq['email'])) {
                    $data['email_err'] = 'No user found. Check your email';
                } else {
                    $data['password_err'] = 'Password incorrect';
                }
                $this->data['subcontent']['errors'] = $data;
            }
        }

        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['title'] = 'Login';
        $this->data['content'] = 'client/auth/login';

        $this->view('layouts/client_layout', $this->data);
    }

    public function register(): void
    {
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['title'] = 'Register';
        $this->data['content'] = 'client/auth/register';

        $this->view('layouts/client_layout', $this->data);
    }

    public function forgotPassword(): void
    {
        $this->view('client/auth/forgot-password');
    }

    public function resetPassword(): void
    {
        $this->view('client/auth/reset-password');
    }

    private function createUserSession($loggedInUser): void
    {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['email'] = $loggedInUser['email'];
        $_SESSION['name'] = $loggedInUser['userName'];
        $_SESSION['avatar'] = $loggedInUser['avatar'];
        header('location: ' . WEB_ROOT . '/trang-chu');
    }
}