<?php

class QuestionModel extends Model {
    public $table = 'questions';

    public function __construct() {
        parent::__construct();
    }

    public function search($searchTerm, $filter, $page) {
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
}