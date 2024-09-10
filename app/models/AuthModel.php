<?php
class AuthModel extends Model
{
    public string $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($email): false|array
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        return $this->db->getOne($sql, ['email' => $email]);
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $user = $this->db->getOne($sql, ['email' => $email]);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }


}