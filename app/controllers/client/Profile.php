<?php
class Profile extends Controller
{
    private mixed $examModel;
    private mixed $userModel;
    private array $data = [];

    public function __construct()
    {
        $this->examModel = $this->model('ExamModel');
        $this->userModel = $this->model('UserModel');
    }

    public function userProfile(): void
    {
        $this->data['subcontent']['tab'] = 'user_profile';
        $this->data['subcontent']['user'] = $this->userModel->getUser($_SESSION['user_id'])[0];
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');

        $this->data['content'] = 'client/profile/user_profile';
        $this->data['title'] = 'Hồ sơ của tôi';

        $this->view('layouts/client_layout', $this->data);
    }

    public function changePassword(): void
    {
        $this->data['subcontent']['tab'] = 'change_password';
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');

        $this->data['content'] = 'client/profile/change_password';
        $this->data['title'] = 'Hồ sơ của tôi';

        $this->view('layouts/client_layout', $this->data);
    }

    public function updateInfo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            $oldAvatar = $this->userModel->getUser($_SESSION['user_id'])[0]['avatar'];
            $checkAvatar = $this->processAvatar();

            if ($checkAvatar['status'] === 'error') {
                echo json_encode([
                    'status' => 'error',
                    'message' => $checkAvatar['message']
                ]);
                return;
            }

            // Xóa avatar cũ
            if ($oldAvatar != '' && $checkAvatar['status'] === 'success') {
                unlink($oldAvatar);
            }

            // Kiểm tra email có tồn tại không
            $emailExit = $this->userModel->checkEmail($data['email'])[0];
            if ($emailExit && $emailExit['email'] !== $_SESSION['email']) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Email đã tồn tại'
                ]);
                return;
            }

            $dataUpdate = [
                'email' => $data['email'],
                'phone' => $data['phone'],
                'avatar' => $checkAvatar['path'] ?? $oldAvatar,
                'updateAt' => date('Y-m-d H:i:s')
            ];

            $res = $this->userModel->update($dataUpdate, ['id' => $_SESSION['user_id']]);
            if ($res) {
                $_SESSION['email'] = $data['email'];
                $_SESSION['avatar'] = $checkAvatar['path'] ?? $_SESSION['avatar'];
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật thông tin thành công',
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Cập nhật thông tin thất bại'
                ]);
            }
        }
    }

    public function updatePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            $user = $this->userModel->getUser($_SESSION['user_id'])[0];
            if (!password_verify($data['old-password'], $user['password'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Mật khẩu cũ không đúng'
                ]);
                return;
            }

            $dataUpdate = [
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'updateAt' => date('Y-m-d H:i:s')
            ];

            $res = $this->userModel->update($dataUpdate, ['id' => $_SESSION['user_id']]);
            if ($res) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cập nhật mật khẩu thành công',
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Cập nhật mật khẩu thất bại'
                ]);
            }
        }
    }

    private function processAvatar(): array
    {
        if (isset($_FILES['avatar'])) {
            // Thư mục lưu trữ ảnh
            $target_dir = "uploads/";
            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            // Tên File
            $filename = pathinfo($_FILES['avatar']['name'], PATHINFO_FILENAME);
            // Lấy phần mở rộng của file
            $imageFileType = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            // Đường dẫn file
            $target_file = $target_dir . $filename . '_' . uniqid() . '.' . $imageFileType;

            // Kiểm tra xem file có phải là file ảnh không
            $check = getimagesize($_FILES["avatar"]["tmp_name"]);
            if (!$check) {
                return [
                    'status' => 'error',
                    'message' => "File không phải là file ảnh"
                ];
            }

            // Kiểm tra file có tồn tại không
            if (file_exists($target_file)) {
                return [
                    'status' => 'error',
                    'message' => "File đã tồn tại"
                ];
            }

            // Kiểm tra kích thước file
            if ($_FILES["avatar"]["size"] > 5000000) {
                return [
                    'status' => 'error',
                    'message' => "File quá lớn"
                ];
            }

            // Kiểm tra định dạng file
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
                return [
                    'status' => 'error',
                    'message' => "Chỉ chấp nhận file JPG, JPEG, PNG & WEBP"
                ];
            }

            // Upload file
            if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                return [
                    'status' => 'error',
                    'message' => "Có lỗi xảy ra khi upload file"
                ];
            }

            return [
                'status' => 'success',
                'path' => $target_file
            ];
        }

        return [
            'status' => 'pass',
            'message' => "Không tìm thấy file"
        ];
    }
}