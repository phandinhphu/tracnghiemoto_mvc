<?php
class Ontap extends Controller {
    private mixed $questionModel;
    private mixed $examModel;
    private array $data = [];

    public function __construct() {
        $this->questionModel = $this->model('QuestionModel');
        $this->examModel = $this->model('ExamModel');
    }

    public function index($page = 1): void
    {
        $res = $this->questionModel->getAll('*', $page);

        $this->data['subcontent']['tab'] = 'ontap';
        $this->data['subcontent']['questions'] = $res['data'];
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['subcontent']['page'] = $page;
        $this->data['subcontent']['totalPage'] = $this->questionModel->getTotalPage($res['total']);
        $this->data['subcontent']['newUrl'] = '/on-tap/trang-';

        $this->data['content'] = 'client/ontap';
        $this->data['title'] = 'Trang ôn tập';

        $this->view('layouts/client_layout', $this->data);
    }

    public function search($page = 1): void
    {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $filter = $_GET['filter'] ?? '';

        $res = $this->questionModel->search($searchTerm, $filter, $page);

        $this->data['subcontent']['tab'] = 'ontap';
        $this->data['subcontent']['questions'] = $res['questions'];
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['subcontent']['page'] = $page;
        $this->data['subcontent']['totalPage'] = $this->questionModel->getTotalPageQuestion($res['total']);
        $this->data['subcontent']['newUrl'] = '/on-tap/tim-kiem/trang-';
        $this->data['subcontent']['paramString'] = '?searchTerm=' . $searchTerm . '&filter=' . $filter;

        $this->data['content'] = 'client/ontap';
        $this->data['title'] = 'Trang ôn tập';

        $this->view('layouts/client_layout', $this->data);
    }
}