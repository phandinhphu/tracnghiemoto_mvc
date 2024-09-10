<?php if (!isset($_SESSION['user_id'])) : ?>
    <div class="app__container">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-8 l-o-2">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Thông báo</div>
                            <div class="panel-body">
                                <?= $message ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($mode) && $mode == 'none') : ?>
    <div class="app__container">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-8 l-o-2">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Các cuộc thi thử đang mở</div>
                            <?php foreach ($exams as $exam) { ?>
                                <div class="panel-body">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <?= $exam['examName'] ?>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="mb-2">Thời gian: <?= $exam['timeLimit'] ?> phút</div>
                                            <div class="mb-2">Số câu hỏi: <?= $exam['soCauHoi'] ?> câu</div>
                                            <div class="">
                                                <button exam-name="<?= $exam['examName'] ?>" class="btn btn-primary btn-start" type="button" align="center">Bắt đầu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($mode) && $mode == 'start') : ?>
    <div id="fixed-info" style="font-size: 1.6rem; padding: 35px;">
        <h2>Tên bài thi:
            <?= $_GET['exam_name'] ?? 'Bài thi trắc nghiệm' ?>
        </h2>
        <p id="time-left">Thời gian còn lại: <?= $timeLimit ?> phút</p>
        <p id="total-question">Số câu hỏi: <?= $totalQuestion ?></p>
        <div class="quiz__progress">
            <svg>
                <circle r="50"></circle>
                <circle id="progress" r="50"></circle>
            </svg>
            <div class="progress__text">
                <span id="percentage">0.0%</span>
            </div>
        </div>
        <div id="list-id">
            <div class="grid wide">
                <div class="row">
                    <?php foreach ($questions as $key => $question) { ?>
                        <div class="col l-2">
                            <a
                                id="group-<?= $question['id'] ?>"
                                class="btn btn-primary list-id-item"
                                href="http://localhost/tracnghiemoto_mvc/thi-thu/start?exam_name=<?= $_GET['exam_name'] ?>#<?= $question['id'] ?>"
                                style="display: block; margin: 5px;"
                            >
                                <span><?= $key + 1 ?></span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="app__container">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-6 l-o-6">
                    <form action="http://localhost/tracnghiemoto_mvc/thi-thu/end" method="post">
                        <div class="panel-group">
                            <?php foreach ($questions as $key => $question) { ?>
                                <div class="panel panel-info">
                                    <div id="<?= $question['id'] ?>" class="panel-body">
                                        <div class="panel-heading">Câu hỏi <?= $key + 1 ?></div>
                                        <div class="panel-body"><?= $question['question'] ?></div>
                                        <div class="panel-footer">
                                            <div class="radio">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="A"
                                                        name="group-<?= $question['id'] ?>"
                                                        style="margin-right: 8px;"
                                                    >
                                                    A. <?= $question['optionA'] ?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="B"
                                                        name="group-<?= $question['id'] ?>"
                                                        style="margin-right: 8px;"
                                                    >
                                                    B. <?= $question['optionB'] ?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="C"
                                                        name="group-<?= $question['id'] ?>"
                                                        style="margin-right: 8px;"
                                                    >
                                                    C. <?= $question['optionC'] ?>
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="D"
                                                        name="group-<?= $question['id'] ?>"
                                                        style="margin-right: 8px;"
                                                    >
                                                    D. <?= $question['optionD'] ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="exam_name" value="<?= $_GET['exam_name'] ?>">
                        <input type="hidden" name="time_complete" value="">
                        <input type="hidden" name="total_question" value="<?= $totalQuestion ?>">
                        <button type="submit" class="btn btn-primary">Nộp bài</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($mode) && $mode == 'end') : ?>
    <div class="app__container">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-3 l-o-2">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Kết quả thi</div>
                            <div class="panel-body">
                                <div class="mb-2">Tên bài thi: <?= $baiThi ?></div>
                                <div class="mb-2">Thời gian làm bài: <?= $timeComplete ?></div>
                                <div class="mb-2">Số câu đúng: <?= $cntTrue ?></div>
                                <div class="mb-2">Số câu sai: <?= $cntFalse ?></div>
                                <div class="mb-2">Số câu trống: <?= $cntTrong ?></div>
                                <div class="mb-2">Điểm: <?= $score ?></div>
                                <div class="mb-2">Kêt quả: <?= $ketQua ?></div>
                            </div>
                        </div>
                        <a class="btn btn-primary" href="http://localhost/tracnghiemoto_mvc/thi-thu">Quay lại</a>
                    </div>
                </div>

                <div class="col l-5">
                    <div class="panel-group">
                        <div class="panel-heading">Bảng đáp án</div>
                        <div class="panel-body"style="
                            overflow: scroll;
                            height: 400px;
                            overflow-x: hidden;
                        ">
                            <?php foreach ($questions as $key => $question) { ?>
                                <div class="panel panel-info">
                                    <div id="<?= $question['id'] ?>" class="panel-body">
                                        <div class="panel-heading">Câu hỏi <?= $key + 1 ?></div>
                                        <div class="panel-body" style="color: <?= $question['result'] == 0 ? 'red' : 'green' ?>;">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <?= $question['question'] ?>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="radio" style="
                                                display: flex;
                                                flex-direction: column;
                                            ">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="A"
                                                        name="group-<?= $question['id'] ?>"
                                                        <?= $question['answerUser'] == 'A' ? 'checked' : '' ?>
                                                        style="margin-right: 8px;"
                                                    >
                                                    A. <?= $question['optionA'] ?>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="B"
                                                        name="group-<?= $question['id'] ?>"
                                                        <?= $question['answerUser'] == 'B' ? 'checked' : '' ?>
                                                        style="margin-right: 8px;"
                                                    >
                                                    B. <?= $question['optionB'] ?>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="C"
                                                        name="group-<?= $question['id'] ?>"
                                                        <?= $question['answerUser'] == 'C' ? 'checked' : '' ?>
                                                        style="margin-right: 8px;"
                                                    >
                                                    C. <?= $question['optionC'] ?>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        value="D"
                                                        name="group-<?= $question['id'] ?>"
                                                        <?= $question['answerUser'] == 'D' ? 'checked' : '' ?>
                                                        style="margin-right: 8px;"
                                                    >
                                                    D. <?= $question['optionD'] ?>
                                                </label>
                                            </div>
                                            <div class="panel-footer" style="color: #06e286">Đáp án đúng: <?= $question['answer'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>

    // start exam
    const handleSubmit = e => {
        window.location.href = `http://localhost/tracnghiemoto_mvc/thi-thu/start?exam_name=${e.target.getAttribute('exam-name')}`;
    }

    $$('.btn-start')?.forEach(btn => {
        btn.addEventListener('click', handleSubmit);
    });

    // countdown
    let timeLimit = <?= $timeLimit ?? 0 ?>;
    if (timeLimit !== 0) {
        let timeComplete = $('input[name="time_complete"]');
        let time = timeLimit * 60;
        let interval = setInterval(() => {
            time--;
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;
            document.getElementById('time-left').innerText = `Thời gian còn lại: ${minutes} phút ${seconds} giây`;

            if (time <= 0) {
                clearInterval(interval);
                alert('Hết thời gian làm bài');
            } else {
                let minutesComplete = Math.floor((timeLimit * 60 - time) / 60);
                let secondsComplete = Math.floor((timeLimit * 60 - time) % 60);
                if (minutesComplete === 0) {
                    timeComplete.value = `${secondsComplete} giây`;
                } else {
                    timeComplete.value = `${minutesComplete} phút ${secondsComplete} giây`;
                }
            }
        }, 1000);
    }

    // progress bar
    let totalQuestion = <?= $totalQuestion ?? 0 ?>;
    if (totalQuestion !== 0) {
        let answerQuestions = 0;
        $$("input[type=radio]").forEach((radio) => {
            radio.addEventListener("change", () => {
                $$(".list-id-item").forEach((id) => {
                    if (radio.name === id.id && id.style.backgroundColor !== "green") {
                        answerQuestions++;
                        id.style.backgroundColor = "green";
                    }

                    let progressCircle = document.getElementById("progress");
                    let percentage = document.getElementById("percentage");

                    let progressPercent = (answerQuestions / totalQuestion) * 100;
                    let circleCircumference = 2 * Math.PI * 50;
                    let offset = circleCircumference - (progressPercent / 100) * circleCircumference;

                    progressCircle.style.strokeDashoffset = offset;

                    if (Number.isInteger(progressPercent)) {
                        percentage.textContent = `${progressPercent}%`;
                    } else {
                        percentage.textContent = `${progressPercent.toFixed(1)}%`;
                    }
                });
            });
        });
    }
</script>