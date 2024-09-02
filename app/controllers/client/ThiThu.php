<?php
class ThiThu extends Controller
{
    private $thithuModel;
    private array $data = [];

    public function __construct()
    {
        $this->thithuModel = $this->model('ExamModel');
    }

    public function index()
    {
        if (isset($_GET['exam_name'])) {
            $data = $this->thithuModel->getByCondition(['examName' => $_GET['exam_name']], '*', 'all');
        } else {
            $data = $this->thithuModel->getByCondition(['status' => 1], '*', 'all');
        }

        $this->data['subcontent']['exams'] = $data;
        $this->data['subcontent']['examName'] = $this->thithuModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['content'] = 'client/thithu';
        $this->data['title'] = 'Thi thử';
        $this->view('layouts/client_layout', $this->data);
    }
}