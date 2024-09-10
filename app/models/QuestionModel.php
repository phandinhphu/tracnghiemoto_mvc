<?php

class QuestionModel extends Model {
    public string $table = 'questions';

    public function __construct() {
        parent::__construct();
    }

    public function search($searchTerm, $filter, $page): array
    {
        $limit = $this->limit;
        $offset = ($page - 1) * $limit;
        $condition = [];
        $sql = 'SELECT * FROM questions';

        if (!empty($searchTerm)) {
            $sql .= " WHERE chuDe = '$searchTerm'";
            $condition['chuDe'] = $searchTerm;
        }

        if (!empty($filter)) {
            $sql .= " AND difficulty = '$filter'";
            $condition['difficulty'] = $filter;
        }

        $total = count($this->db->get($this->table, $condition));

        $sql .= " LIMIT $offset, $limit";

        return [
            'questions' => $this->db->getAll($sql),
            'total' => $total
        ];
    }

    public function getTotalPageQuestion($total): int
    {
        return ceil($total/$this->limit);
    }

    public function getRandomQuestion($examName, $totalQuestion): array
    {
        $sql = "SELECT * FROM questions WHERE chuDe = :chuDe ORDER BY RAND() LIMIT $totalQuestion";
        return $this->db->getAll($sql, ['chuDe' => $examName]);
    }

    public function getQuestionByIdAndTestDate($testDate, $userId): array
    {
        $sql = "SELECT history.id AS historyId, history.answerUser, history.result, questions.* 
                FROM history, questions
                WHERE history.questionId = questions.id
                AND history.dateAnswer = :testDate AND history.userId = :userId";

        return $this->db->getAll($sql, ['testDate' => $testDate, 'userId' => $userId]);
    }
}