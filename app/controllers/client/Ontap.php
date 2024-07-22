<?php
class Ontap extends Controller {
    private $questionModel;
    private $examModel;
    private $data = [];

    public function __construct() {
        $this->questionModel = $this->model('QuestionModel');
        $this->examModel = $this->model('ExamModel');
    }

    public function index($page = 1): void
    {
        $this->data['subcontent']['questions'] = $this->questionModel->getAll('*', $page);
        $this->data['subcontent']['examName'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['subcontent']['page'] = $page;
        $this->data['subcontent']['totalPage'] = $this->questionModel->getTotalPage();
        $this->data['content'] = 'client/ontap';
        $this->data['title'] = 'Trang ôn tập';

        $this->view('layouts/client_layout', $this->data);
    }
}