<?php
class ResultModel extends Model
{
    public string $table = 'result';

    public function __construct() {
        parent::__construct();
    }

    public function getExams($userId, $page = 1, $examName = '', $testDate = ''): array|false
    {
        $offset = ($page - 1) * $this->limit;
        $condition = ['userId' => $userId];
        $placeHolder = ['userId' => $userId];
        $order = 'testDate DESC';

        if ($examName) {
            $condition['examName'] = $examName;
            $placeHolder['examName'] = $examName;
        }

        if ($testDate) {
            $order = $testDate == 'asc' ? 'testDate ASC' : 'testDate DESC';
        }

        $stringPlaceHolder = implode(' and ', array_map(fn($key) => "$key = :$key", array_keys($placeHolder)));

        $total = count($this->db->get($this->table, $condition, '*'));

        $sql = "SELECT * FROM result
                WHERE  $stringPlaceHolder
                ORDER BY $order LIMIT $offset, $this->limit";

        return [
            'data' => $this->db->getAll($sql, $condition),
            'total' => $total
        ];
    }

    public function getExamDetail($userId, $testDate): array|false
    {
        $sql = "SELECT userName, phone, email, result.examName, testDate, 
                timeLimit, timeComplete, soCauHoi, soCauDung, soCauSai, soCauTrong, score, ketQua
                FROM users, result, exam
                WHERE users.id = result.userId AND result.examName = exam.examName
                AND users.id = :userId AND testDate = :testDate";

        return $this->db->getOne($sql, ['userId' => $userId, 'testDate' => $testDate]);
    }
}