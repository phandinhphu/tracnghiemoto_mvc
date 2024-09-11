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
<?php else : ?>
<div class="app__container">
    <div class="grid wide">
        <div class="row">
            <div class="col c-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Lịch sử</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="list-group-link" href="<?= WEB_ROOT . '/lich-su/cau-hoi' ?>">Lịch sử câu hỏi</a>
                            </li>
                            <li class="list-group-item">
                                <a class="list-group-link" href="<?= WEB_ROOT . '/lich-su/bai-thi' ?>">Lịch sử bài thi</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php if (isset($exams) || isset($questions)) : ?>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>
                            Filter
                            <i class="fa fa-filter" aria-hidden="true"></i>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= isset($exams) ?
                            WEB_ROOT . '/lich-su/bai-thi' :
                            WEB_ROOT . '/lich-su/cau-hoi'
                        ?>" method="get">
                            <div class="form__group">
                                <label for="examName">Chọn bài thi</label>
                                <?php
                                foreach ($examNames as $exam) : ?>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" type="radio" name="exam_name" id="<?= $exam['examName'] ?>" value="<?= $exam['examName'] ?>" <?= isset($_GET['exam_name']) && $_GET['exam_name'] == $exam['examName'] ? 'checked' : '' ?>>
                                        <label class="form-check-label ml-2" for="<?= $exam['examName']; ?>">
                                            <?= $exam['examName']; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="form__group">
                                <label for="dateAnswer">
                                    <?= isset($exams) ? 'Sắp xếp theo ngày làm bài' : 'Sắp xếp theo ngày trả lời' ?>
                                </label>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="date_answer" id="asc" value="asc" <?= isset($_GET['date_answer']) && $_GET['date_answer'] == 'asc' ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-2" for="asc">
                                        Tăng dần
                                    </label>
                                </div>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="date_answer" id="desc" value="desc" <?= isset($_GET['date_answer']) && $_GET['date_answer'] == 'desc' ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-2" for="desc">
                                        Giảm dần
                                    </label>
                                </div>
                            </div>

                            <div class="form__group">
                                <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                            </div>
                            <div class="form__group">
                                <a class="btn btn-primary mt-3" href="<?= isset($exams) ? WEB_ROOT . '/lich-su/bai-thi' :
                                    WEB_ROOT . '/lich-su/cau-hoi' ?>">Hủy lọc</a>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col c-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?= $title ?? 'Lịch sử' ?></h3>
                        <h3 style="color: red; margin-bottom: 0">
                            *Lưu ý: Nếu bạn không thấy dữ liệu, vui lòng chọn các options trong bảng "Lịch sử" bên trái <br>
                            <===||
                        </h3>
                    </div>
                    <?php if (isset($exams) || isset($questions)) : ?>
                    <div class="card-body">
                        <div id="form-profile">
                            <table class="table">
                                <?php if (isset($exams)) : ?>
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên bài thi</th>
                                        <th scope="col">Điểm</th>
                                        <th scope="col">Time complete</th>
                                        <th scope="col">Test date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($exams as $key => $exam) : ?>
                                        <tr>
                                            <th scope="row"><?php echo $key + 1; ?></th>
                                            <td><?php echo $exam['examName']; ?></td>
                                            <td><?php echo $exam['score']; ?>/100</td>
                                            <td><?php echo $exam['timeComplete']; ?></td>
                                            <td><?php echo $exam['testDate']; ?></td>
                                            <td style="
                                                        display: flex;
                                                    ">
                                                <button class="btn btn-primary btn-detail" data-toggle="modal" data-target="#modalDetail" value="<?= $exam['userId'] ?>" test-date="<?= $exam['testDate'] ?>" >Chi tiết</button>
                                                <button class="btn btn-success btn-export ml-2" test-date="<?= $exam['testDate'] ?>" >Export excel</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                <?php else : ?>
                                    <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Câu hỏi</th>
                                        <th scope="col">Câu trả lời</th>
                                        <th scope="col">Kết quả</th>
                                        <th scope="col">Ngày trả lời</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($questions as $key => $question) : ?>
                                            <tr>
                                                <th scope="row"><?php echo $key + 1; ?></th>
                                                <td><?php echo $question['question']; ?></td>
                                                <td><?php echo $question['answerUser']; ?></td>
                                                <td><?php echo $question['result'] == 1 ? 'Đúng' : 'Sai'; ?></td>
                                                <td><?php echo $question['dateAnswer']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col c-3" style="
                        position: fixed;
                        right: 0;
                    ">
                <div class="card">
                    <div class="card-header">
                        <h3>Phân trang</h3>
                    </div>
                    <div class="card-body">
                        <nav aria-label="Page navigation" style="
                                    overflow-x: hidden;
                                    overflow-y: scroll;
                                    max-height: 387px;
                                ">
                            <ul class="pagination" style="flex-wrap: wrap;">
                                <?php if ($page > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= WEB_ROOT . $newUrl . ($page - 1) . '.html' . $paramsString ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?= WEB_ROOT . $newUrl . ($i) . '.html' . $paramsString ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPage) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= WEB_ROOT . $newUrl . ($page + 1) . '.html' . $paramsString ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="End">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="modal fade" tabindex="-1" id="modalDetail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 2.2rem;">Chi tiết</h4>
            </div>
            <div class="modal-body" style="
                    font-size: 1.4rem;
                    overflow: scroll;
                    height: 400px;
                    overflow-x: hidden;
                ">
                <div id="list-answer"></div>
            </div>
            <div class="modal-footer">
                <button id="btn-modal-close" type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-export').onclick = (e) => {
        let testDate = e.target.getAttribute('test-date');
        window.location.href = '<?= WEB_ROOT . '/lich-su/bai-thi/tai-xuong' ?>' + '?test_date=' + testDate + '&download=true';
    }
</script>
<script>
    $('.btn-detail').onclick = async (e) => {
        let userId = e.target.value;
        let testDate = e.target.getAttribute('test-date');

        let data = new FormData();
        data.append('userId', userId);
        data.append('testDate', testDate);

        let res = await fetch('<?= WEB_ROOT . '/lich-su/chi-tiet' ?>', {
            method: 'POST',
            body: data
        });

        let result = await res.json();

        const listAnswerDOM = document.getElementById('list-answer');
        listAnswerDOM.innerHTML = '';
        result.forEach((question, index) => {
            const div = document.createElement('div');
            div.classList.add('divst-group-item');
            div.innerHTML = `
                <div class="panel-heading">Câu hỏi ${index + 1}</div>
                <div class="panel-body" style="color: ${question.result === 0 ? 'red' : 'green'}">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    ${question.question}
                </div>
                <div class="panel-footer">
                    <div class="radio" style="
                        display: flex;
                        flex-direction: column;
                    ">
                        <label>
                            <input class="mr-2" type="radio" value="A" name="group-${question.id}" ${question.answerUser === 'A' ? 'checked' : ''} disabled>
                            A. ${question.optionA}
                        </label>

                        <label><input class="mr-2" type="radio" value="B" name="group-${question.id}" ${question.answerUser === 'B' ? 'checked' : ''} disabled>
                            B. ${question.optionB}
                        </label>

                        <label><input class="mr-2" type="radio" value="C" name="group-${question.id}" ${question.answerUser === 'C' ? 'checked' : ''} disabled>
                            C. ${question.optionC}
                        </label>

                        <label><input class="mr-2" type="radio" value="D" name="group-${question.id}" ${question.answerUser === 'D' ? 'checked' : ''} disabled>
                            D. ${question.optionD}
                        </label>
                    </div>
                    <div class="panel-footer">Đáp án đúng: ${question.answer}</div>
                </div>
            `;
            listAnswerDOM.appendChild(div);
        });

        jQuery("#modalDetail").modal();
    }
</script>
