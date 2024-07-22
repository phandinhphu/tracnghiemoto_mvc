<div class="app__container">
    <div class="grid wide">
        <div class="row">
            <div class="col l-3 c-3">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>
                            Filter
                            <i class="fa fa-filter" aria-hidden="true"></i>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                            <input type="hidden" name="module" value="pages">
                            <input type="hidden" name="action" value="ontap">
                            <div class="form-group">
                                <label for="examName">Chọn bài thi</label>
                                <?php
                                foreach ($examName as $exam) : ?>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" type="radio" name="examName" id="<?php echo $exam['examName']; ?>" value="<?php echo $exam['examName']; ?>" <?php echo isset($_GET['examName']) && $_GET['examName'] == $exam['examName'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label ml-2" for="<?php echo $exam['examName']; ?>">
                                            <?php echo $exam['examName']; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label for="_sort">Sắp xếp theo độ khó</label>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="_sort" id="easy" value="easy" <?php echo isset($_GET['_sort']) && $_GET['_sort'] == 'easy' ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-2" for="easy">
                                        Easy
                                    </label>
                                </div>
                                <div class="form-check ml-5">
                                    <input class="form-check-input" type="radio" name="_sort" id="hard" value="hard" <?php echo isset($_GET['_sort']) && $_GET['_sort'] == 'hard' ? 'checked' : ''; ?>>
                                    <label class="form-check-label ml-2" for="hard">
                                        Hard
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                            <a class="btn btn-primary mt-3 ml-4" href="?module=pages&action=ontap">Hủy lọc</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col l-6 c-6">
                <div class="card">
                    <div class="card-header">
                        <h1>Câu hỏi ôn tập</h1>
                    </div>
                    <div class="card-body">
                        <?php
                        $i = 0;
                        foreach ($questions as $question) :
                            ?>
                            <div class="question">
                                <p class="question__content"><?= ++$i ?>. <?php echo $question['question']; ?></p>
                                <ul class="question__answers">
                                    <li class="question__answer">
                                        <label>A. <?php echo $question['optionA']; ?></label>
                                    </li>
                                    <li class="question__answer">
                                        <label>B. <?php echo $question['optionB']; ?></label>
                                    </li>
                                    <li class="question__answer">
                                        <label>C. <?php echo $question['optionC']; ?></label>
                                    </li>
                                    <li class="question__answer">
                                        <label>D. <?php echo $question['optionD']; ?></label>
                                    </li>
                                    <li class="question__answer">
                                        <label class="question__correct">
                                            Đáp án: <?php echo $question['answer']; ?>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
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
                                        <a class="page-link" href="<?= WEB_ROOT . '/client/ontap/index/' . ($page - 1) ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?= WEB_ROOT . '/client/ontap/index/' . ($i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPage) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= WEB_ROOT . '/client/ontap/index/' . ($page + 1) ?>" aria-label="Next">
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