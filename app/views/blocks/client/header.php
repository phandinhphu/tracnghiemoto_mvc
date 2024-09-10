<header>
    <div class="header">
        <div class="header__first">
            <a href="?module=pages&action=trangchu">
                <h1>Thi Lái Xe Ô tô</h1>
            </a>
            <div class="header__menu">
                <ul class="first__list">
                    <li class="first__items <?= isset($tab) && $tab == 'trangchu' ? 'active' : '' ?>">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/trang-chu' ?>">Trang chủ</a>
                    </li>
                    <li class="first__items <?= isset($tab) && $tab == 'ontap' ? 'active' : '' ?>">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/on-tap' ?>">Ôn tập</a>
                    </li>
                    <li class="first__items <?= isset($tab) && $tab == 'thithu' ? 'active' : '' ?>">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/thi-thu' ?>">Thi thử</a>
                        <ul class="context__list">
                            <?php foreach ($examNames as $exam) : ?>
                                <li class="context__items">
                                    <a class="context__items-link" href="<?= WEB_ROOT . '/thi-thu?exam_name=' ?><?= $exam['examName']; ?>"><?= $exam['examName']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="first__items <?= isset($tab) && $tab == 'history' ? 'active' : '' ?>">
                        <a class="first__items-link" href="<?= WEB_ROOT . '/lich-su' ?>">Lịch sử</a>
                    </li>
                    <li class="line"></li>
                </ul>
            </div>
        </div>

        <div class="header__second">
            <div class="header__second-user">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <div class="header__second-user-info">
                        <img src="<?= WEB_ROOT . '/' . $_SESSION['avatar'] ?>" alt="<?= $_SESSION['name'] ?>" class="header__second-user-avatar">
                        <span class="header__second-user-name"><?= $_SESSION['name'] ?></span>
                    </div>
                    <div class="header__second-user-menu">
                        <ul class="second__list">
                            <li class="second__items">
                                <a class="second__items-link" href="<?= WEB_ROOT . '/ho-so' ?>">Thông tin cá nhân</a>
                            </li>
                            <li class="second__items">
                                <a class="second__items-link" href="<?= WEB_ROOT . '/dang-xuat' ?>">Đăng xuất</a>
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

<script>
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    let tabActive = $('.first__items.active');
    let line = $('.line');

    // Process active
    let offsetLeft = tabActive?.offsetLeft;
    let offsetWidth = tabActive?.offsetWidth;
    line.style = `
        transform: translateX(${offsetLeft}px);
        width: ${offsetWidth}px;
    `

    // Process hover
    $$('.first__items').forEach(item => {
        item.addEventListener('mouseenter', e => {
            let offsetLeft = e.target.offsetLeft;
            let offsetWidth = e.target.offsetWidth;

            line.style = `
                transform: translateX(${offsetLeft}px);
                width: ${offsetWidth}px;
            `
        })

        item.addEventListener('mouseleave', e => {
            let offsetLeft = tabActive?.offsetLeft;
            let offsetWidth = tabActive?.offsetWidth;

            line.style = `
                transform: translateX(${offsetLeft}px);
                width: ${offsetWidth}px;
            `
        })
    })
</script>