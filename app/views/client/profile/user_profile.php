<div class="app__container">
    <div class="grid wide">
        <div class="row">
            <?php
            $this->view('client/profile/sidebar', ['tab' => $tab]);
            ?>
            <div class="col c-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Hồ sơ của tôi</h3>
                        <div class="alert" role="alert">
                            <strong></strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form">
                            <div class="form__group">
                                <div class="avatar__label">
                                    <img src="<?= $user['avatar'] ?>" alt="<?= $_SESSION['name'] ?>" class="avatar" title="Avatar">
                                    <input type="file" class="form__input" rules="required" id="avatar" name="avatar">
                                </div>
                                <span class="form__message"></span>
                            </div>
                            <div class="form__group">
                                <label for="username" class="form__label">Username</label>
                                <input type="text" name="username" id="username" class="form__input" value="<?= $_SESSION['name'] ?>" readonly>
                            </div>
                            <div class="form__group">
                                <label for="email" class="form__label">Email</label>
                                <input type="email" name="email" rules="required|email" id="email" class="form__input" value="<?= $user['email'] ?? '' ?>">
                                <span class="form__message">
                                    <?php if (isset($errors['email_err'])) : ?>
                                        <?= $errors['email_err'] ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="form__group">
                                <label for="phone" class="form__label">Phone</label>
                                <input type="text" name="phone" rules="required|phone" id="phone" class="form__input" value="<?= $user['phone'] ?? '' ?>">
                                <span class="form__message"></span>
                            </div>
                            <button type="submit" class="btn btn-primary js-save-info">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= WEB_ROOT . '/public/assets/client/js/validator.js' ?>"></script>
<script>
    let avatar = $('.avatar');
    let inputImg = $('#avatar');

    inputImg.onchange = () => {
        const [file] = inputImg.files;
        if (file) {
            avatar.src = URL.createObjectURL(file);
        }
    }
</script>
<script>
    new Validator('#form').onSubmit = async (data) => {
        // console.log(data.avatar[0]);

        let req = new FormData();
        req.append('avatar', data.avatar[0]);
        req.append('email', data.email);
        req.append('phone', data.phone);

        const response = await fetch('http://localhost/tracnghiemoto_mvc/ho-so/cap-nhat', {
            method: 'POST',
            body: req
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