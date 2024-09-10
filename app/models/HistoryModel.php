<?php
class HistoryModel extends Model
{
    public string $table = 'history';
    public function __construct()
    {
        parent::__construct();
    }

    public function getHistoryQuestions($userId, $page = 1, $examName = '', $dateAnswer = ''): array|false
    {
        $offset = ($page - 1) * $this->limit;
        $condition = ['userId' => $userId];
        $placeHolder = ['userId' => $userId];
        $order = 'dateAnswer DESC';

        if ($examName) {
            $condition['chuDe'] = $examName;
            $placeHolder['chuDe'] = $examName;
        }

        if ($dateAnswer) {
            $order = $dateAnswer == 'asc' ? 'dateAnswer ASC' : 'dateAnswer DESC';
        }

        $stringPlaceHolder = implode(' and ', array_map(fn($key) => "$key = :$key", array_keys($placeHolder)));

        $sql = "SELECT history.*, questions.question FROM history, questions
                WHERE history.questionId = questions.id and $stringPlaceHolder";

        if ($examName) {
            $total = count($this->db->getAll($sql, $condition));
        } else {
            $total = count($this->db->get($this->table, ['userId' => $userId], '*'));
        }

        $sql .= " ORDER BY $order LIMIT $offset, $this->limit";

        return [
            'data' => $this->db->getAll($sql, $condition),
            'total' => $total
        ];
    }
}