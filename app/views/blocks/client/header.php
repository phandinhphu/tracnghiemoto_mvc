<header>
    <div class="header">
        <div class="header__first">
            <a href="?module=pages&action=trangchu">
                <h1>Thi Lái Xe Ô tô</h1>
            </a>
            <div class="header__menu">
                <ul class="first__list">
                    <li class="first__items">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/trang-chu' ?>">Trang chủ</a>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/on-tap' ?>">Ôn tập</a>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/thi-thu' ?>">Thi thử</a>
                        <ul class="context__list">
                            <?php foreach ($examName as $exam) : ?>
                                <li class="context__items">
                                    <a class="context__items-link" href="http://localhost/tracnghiemoto_mvc/thi-thu?exam_name=<?php echo $exam['examName']; ?>"><?php echo $exam['examName']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="http://localhost//tracnghiemoto_mvc/lich-su">Lịch sử</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="header__second">
            <div class="header__second-user">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <span class="header__second-user-name"><?= $_SESSION['name'] ?></span>
                    <div class="header__second-user-menu">
                        <ul class="second__list">
                            <li class="second__items">
                                <a class="second__items-link" href="?module=pages&action=profile">Thông tin cá nhân</a>
                            </li>
                            <li class="second__items">
                                <a class="second__items-link" href="?module=auth&action=logout">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="header__menu">
                        <ul class="first__list">
                            <li class="first__items">
                                <a class="first__items-link" href="<?= WEB_ROOT . '/dang-nhap' ?>">Đăng nhập</a>
                            </li>
                            <li class="first__items">
                                <a class="first__items-link" href="<?= WEB_ROOT . '/dang-ky' ?>">Đăng ký</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>