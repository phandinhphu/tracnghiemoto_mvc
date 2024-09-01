<?php

class QuestionModel extends Model {
    public $table = 'questions';
    protected Database $db;

    public function __construct() {
        parent::__construct();
        $this->db = Database::GetInstance();
    }

    public function search($searchTerm, $filter, $page) {
        $limit = $this->limit;
        $offset = ($page - 1) * $limit;
        $sql = 'SELECT * FROM questions';

        if (!empty($searchTerm)) {
            $sql .= " WHERE chuDe = '$searchTerm'";
        }

        if (!empty($filter)) {
            $sql .= " AND difficulty = '$filter'";
        }

        $total = count($this->db->get($this->table, ['chuDe' => $searchTerm, 'difficulty' => $filter]));

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
}