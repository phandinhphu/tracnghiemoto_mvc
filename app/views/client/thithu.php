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