<div class="col c-3">
    <div class="card">
        <div class="card-header">
            <h3>Tài khoản của tôi</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <a class="list-group-link <?= $tab == 'user_profile' ? 'selected' : '' ?>" href="<?= WEB_ROOT . '/ho-so' ?>">Hồ sơ</a>
                </li>
                <li class="list-group-item">
                    <a class="list-group-link <?= $tab == 'change_password' ? 'selected' : '' ?>" href="<?= WEB_ROOT . '/doi-mat-khau' ?>">Đổi mật khẩu</a>
                </li>
            </ul>
        </div>
    </div>
</div>