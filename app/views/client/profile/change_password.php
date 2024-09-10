<div class="app__container">
    <div class="grid wide">
        <div class="row">
            <?php
            $this->view('client/profile/sidebar', ['tab' => $tab]);
            ?>
            <div class="col c-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Đổi mật khẩu</h3>
                        <div class="alert" role="alert">
                            <strong></strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form">
                            <div class="form__group">
                                <label for="old-password" class="form__label">Nhập password cũ</label>
                                <input type="password" rules="required|min:6" name="old-password" id="old-password" class="form__input">
                                <span class="form__message"></span>
                            </div>
                            <div class="form__group">
                                <label for="password" class="form__label">Nhập password mới</label>
                                <input type="password" rules="required|min:6" name="password" id="password" class="form__input">
                                <span class="form__message"></span>
                            </div>
                            <div class="form__group">
                                <label for="rpassword" class="form__label">Confime password</label>
                                <input type="password" rules="required|confirmation" name="rpassword" id="rpassword" class="form__input">
                                <span class="form__message"></span>
                            </div>
                            <button type="submit" class="btn btn-primary js-save-rpassword">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= WEB_ROOT . '/public/assets/client/js/validator.js' ?>"></script>

<script>
    new Validator('#form').onSubmit = async data => {
        const response = await fetch('http://localhost/tracnghiemoto_mvc/doi-mat-khau/cap-nhat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const { status, message } = await response.json();
        let alert = $('.alert');

        if (status === 'error') {
            alert.classList.add('alert-danger');
            alert.classList.remove('alert-success');
            alert.querySelector('strong').textContent = message;
        } else {
            alert.classList.add('alert-success');
            alert.classList.remove('alert-danger');
            alert.querySelector('strong').textContent = message;
        }
    }
</script>