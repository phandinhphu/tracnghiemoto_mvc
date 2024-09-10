<?php
class UserModel extends Model
{
    public string $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function checkEmail($email): false|array
    {
        return $this->db->get($this->table, ['email' => $email], 'email');
    }

    public function getUser($id): false|array
    {
        return $this->db->get($this->table, ['id' => $id], '*');
    }
}