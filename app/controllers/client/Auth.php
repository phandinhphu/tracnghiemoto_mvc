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

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dataReq = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            $loggedInUser = $this->authModel->login($dataReq['email'], $dataReq['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                if (!$this->authModel->getUser($dataReq['email'])) {
                    $data['email_err'] = 'No user found. Check your email';
                }
                $data['password_err'] = 'Password incorrect';
                $this->data['subcontent']['errors'] = $data;
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
        }

        $this->data['subcontent']['examName'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['title'] = 'Login';
        $this->data['content'] = 'client/auth/login';

        $this->view('layouts/client_layout', $this->data);
    }

    public function register(): void
    {
        $this->data['subcontent']['examName'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['title'] = 'Login';
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
        header('location: http://localhost/tracnghiemoto_mvc/trang-chu');
    }
}