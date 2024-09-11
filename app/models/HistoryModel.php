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

    public function getExamDetail($userId, $testDate): array|false
    {
        $sql = "SELECT questions.*, history.answerUser, history.result
                FROM history, questions
                WHERE history.questionId = questions.id AND 
                history.userId = :userId AND history.dateAnswer = :testDate";

        return $this->db->getAll($sql, ['userId' => $userId, 'testDate' => $testDate]);
    }

    public function getQuestionsByTestDate($testDate): array
    {
        $sql = 'SELECT question, optionA, optionB, optionC, optionD, answerUser, answer, case 
                when result = 0 then "Sai"
                ELSE "Đúng"
                END AS "kết quả" FROM history, questions
                WHERE history.questionId = questions.id
                AND dateAnswer = :dateAnswer';

        return $this->db->getAll($sql, ['dateAnswer' => $testDate]);
    }
}