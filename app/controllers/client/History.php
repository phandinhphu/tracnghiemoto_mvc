<?php
class History extends Controller
{
    public mixed $historyModel;
    public mixed $examModel;
    public mixed $resultModel;
    private array $data = [];

    public function __construct()
    {
        $this->historyModel = $this->model('HistoryModel');
        $this->examModel = $this->model('ExamModel');
        $this->resultModel = $this->model('ResultModel');
    }

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->data['subcontent']['message'] = 'Bạn cần đăng nhập để xem lịch sử làm bài thi';
        } else {
            $this->data['subcontent']['page'] = 1;
            $this->data['subcontent']['totalPage'] = 0;
            $this->data['subcontent']['newUrl'] = '/lich-su/cau-hoi/trang-';
        }

        $this->data['subcontent']['tab'] = 'history';
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');

        $this->data['content'] = 'client/history';
        $this->data['title'] = 'Lịch sử làm bài thi';
        $this->view('layouts/client_layout', $this->data);
    }

    public function questions($page = 1): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->data['subcontent']['message'] = 'Bạn cần đăng nhập để xem lịch sử làm bài thi';
        } else {
            $examName = $_GET['exam_name'] ?? '';

            $dateAnswer = $_GET['date_answer'] ?? '';

            $res = $this->historyModel->getHistoryQuestions($_SESSION['user_id'], $page, $examName, $dateAnswer);

            $this->data['subcontent']['questions'] = $res['data'];
            $this->data['subcontent']['page'] = $page;
            $this->data['subcontent']['totalPage'] = $this->historyModel->getTotalPage($res['total']);
            $this->data['subcontent']['paramsString'] = '?exam_name=' . $examName . '&date_answer=' . $dateAnswer;
            $this->data['subcontent']['newUrl'] = '/lich-su/cau-hoi/trang-';
        }

        $this->data['subcontent']['tab'] = 'history';
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');

        $this->data['content'] = 'client/history';
        $this->data['title'] = 'Lịch sử làm bài thi';
        $this->view('layouts/client_layout', $this->data);
    }

    public function exams($page = 1): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->data['subcontent']['message'] = 'Bạn cần đăng nhập để xem lịch sử làm bài thi';
        } else {
            $examName = $_GET['exam_name'] ?? '';

            $dateAnswer = $_GET['date_answer'] ?? '';

            $res = $this->resultModel->getExams($_SESSION['user_id'], $page, $examName, $dateAnswer);

            $this->data['subcontent']['exams'] = $res['data'];
            $this->data['subcontent']['page'] = $page;
            $this->data['subcontent']['totalPage'] = $this->resultModel->getTotalPage($res['total']);
            $this->data['subcontent']['paramsString'] = '?exam_name=' . $examName . '&date_answer=' . $dateAnswer;
            $this->data['subcontent']['newUrl'] = '/lich-su/bai-thi/trang-';
        }

        $this->data['subcontent']['tab'] = 'history';
        $this->data['subcontent']['examNames'] = $this->examModel->getByCondition(['status' => 1], 'examName', 'all');

        $this->data['content'] = 'client/history';
        $this->data['title'] = 'Lịch sử làm bài thi';
        $this->view('layouts/client_layout', $this->data);
    }
}