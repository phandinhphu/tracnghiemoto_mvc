<?php
class Home extends Controller {
    private mixed $examModel;
    private array $data = [];

    public function __construct() {
        $this->examModel = $this->model('ExamModel');
    }

    public function index(): void
    {
        $this->data['subcontent']['tab'] = 'trangchu';
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['content'] = 'client/home';

        $this->view('layouts/client_layout', $this->data);
    }
}