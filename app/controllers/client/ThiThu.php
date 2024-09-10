<?php
class ThiThu extends Controller
{
    private mixed $thithuModel;
    private mixed $questionModel;
    private mixed $historyModel;
    private mixed $resultModel;
    private array $data = [];

    public function __construct()
    {
        $this->thithuModel = $this->model('ExamModel');
        $this->questionModel = $this->model('QuestionModel');
        $this->historyModel = $this->model('HistoryModel');
        $this->resultModel = $this->model('ResultModel');
    }

    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->data['subcontent']['message'] = 'Bạn cần đăng nhập để tham gia thi thử';
        } else {
            if (isset($_GET['exam_name'])) {
                $data = $this->thithuModel->getByCondition(['examName' => $_GET['exam_name']], '*', 'all');
            } else {
                $data = $this->thithuModel->getByCondition(['status' => 1], '*', 'all');
            }

            $this->data['subcontent']['exams'] = $data;
        }

        $this->data['subcontent']['tab'] = 'thithu';
        $this->data['subcontent']['examNames'] = $this->thithuModel->getByCondition(['status' => 1], 'examName', 'all');
        $this->data['subcontent']['mode'] = 'none';

        $this->data['content'] = 'client/thithu';
        $this->data['title'] = 'Thi thử';
        $this->view('layouts/client_layout', $this->data);
    }

    public function start(): void
    {
        if (isset($_GET['exam_name'])) {
            $exam = $this->thithuModel->getByCondition(['examName' => $_GET['exam_name']], '*', 'all');
            $questions = $this->questionModel->getRandomQuestion($_GET['exam_name'], $exam[0]['soCauHoi']);

            $this->data['subcontent']['tab'] = 'thithu';
            $this->data['subcontent']['questions'] = $questions;
            $this->data['subcontent']['totalQuestion'] = $exam[0]['soCauHoi'];
            $this->data['subcontent']['timeLimit'] = $exam[0]['timeLimit'];
            $this->data['subcontent']['examNames'] = $this->thithuModel->getByCondition(['status' => 1], 'examName', 'all');
            $this->data['subcontent']['mode'] = 'start';

            $this->data['content'] = 'client/thithu';
            $this->data['title'] = 'Bắt đầu thi';
            $this->view('layouts/client_layout', $this->data);
        } else {
            // ...do something
            echo 'Hello';
        }
    }

    public function end(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // POST data
            $examName = $_POST['exam_name'];
            $timeComplete = $_POST['time_complete'];
            $totalQuestion = $_POST['total_question'];

            // Initialize data score
            $cntTrue = 0;
            $cntFalse = 0;
            $dataAnwser = date('Y-m-d H:i:s');

            // Initialize array user's answers
            $answers = [];
            foreach ($_POST as $key => $value) {
                if (str_starts_with($key, 'group')) {
                    $answers[explode('-', $key)[1]] = $value;
                }
            }

            // Insert history
            $this->saveResultAnswers($answers, $dataAnwser, $cntTrue, $cntFalse);

            // Calculate score
            $dataScore = $this->calculateScore($cntTrue, $cntFalse, $totalQuestion);

            // Insert Result
            $dataInsert = [
                'userId' => $_SESSION['user_id'],
                'examName' => $examName,
                'score' => $dataScore['score'],
                'soCauDung' => $cntTrue,
                'soCauSai' => $cntFalse,
                'soCauTrong' => $dataScore['cntTrong'],
                'timeComplete' => $timeComplete,
                'testDate' => $dataAnwser,
                'ketQua' => $dataScore['score'] >= 70 ? 'Đạt' : 'Không đạt'
            ];
            $this->resultModel->Add($dataInsert);

            // Render view
            $this->data['subcontent']['tab'] = 'thithu';
            $this->data['subcontent']['examNames'] = $this->thithuModel->getByCondition(['status' => 1], 'examName', 'all');
            $this->data['subcontent']['questions'] = $this->questionModel->getQuestionByIdAndTestDate($dataAnwser, $_SESSION['user_id']);
            $this->data['subcontent']['mode'] = 'end';
            $this->data['subcontent']['score'] = $dataScore['score'];
            $this->data['subcontent']['timeComplete'] = $timeComplete;
            $this->data['subcontent']['cntTrue'] = $cntTrue;
            $this->data['subcontent']['cntFalse'] = $cntFalse;
            $this->data['subcontent']['cntTrong'] = $dataScore['cntTrong'];
            $this->data['subcontent']['ketQua'] = $dataScore['score'] >= 70 ? 'Đạt' : 'Không đạt';
            $this->data['subcontent']['baiThi'] = $examName;

            $this->data['content'] = 'client/thithu';
            $this->data['title'] = 'Kết quả thi';
            $this->view('layouts/client_layout', $this->data);
        }
    }

    private function saveResultAnswers($answers, $dataAnwser, &$cntTrue, &$cntFalse): void
    {
        foreach ($answers as $key => $value) {
            $answer = $this->questionModel->getByCondition(['id' => $key], 'answer', 'all')[0];
            if ($answer['answer'] == $value) {
                $cntTrue++;
            } else {
                $cntFalse++;
            }

            $dataInsert = [
                'userId' => $_SESSION['user_id'],
                'questionId' => $key,
                'answerUser' => $value,
                'result' => $answer['answer'] == $value ? 1 : 0,
                'dateAnswer' => $dataAnwser
            ];
            $this->historyModel->Add($dataInsert);
        }
    }

    private function calculateScore($cntTrue, $cntFalse, $total): array
    {
        $cntTrong = 0;
        if ($cntTrue + $cntFalse < $total) {
            $cntTrong = $total - $cntTrue - $cntFalse;
        }

        $score = round(100 * $cntTrue / $total, 2);
        return [
            'score' => $score,
            'cntTrong' => $cntTrong
        ];
    }
}