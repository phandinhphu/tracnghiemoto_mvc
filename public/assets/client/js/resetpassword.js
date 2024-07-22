const btnSave = document.querySelector('.js-save-rpassword');

btnSave.addEventListener('click', () => {
    document.querySelector('.alert strong').innerHTML = '';

    let old_password = document.getElementById('old-password').value;
    let new_password = document.getElementById('password').value;
    let confirm_password = document.getElementById('rpassword').value;

    if (old_password == '' || new_password == '' || confirm_password == '') {
        document.querySelector('.alert').classList.toggle('alert-danger');
        document.querySelector('.alert strong').innerHTML = 'Vui lòng nhập đầy đủ thông tin';
        return;
    }

    if (new_password.length < 6) {
        document.querySelector('.alert').classList.toggle('alert-danger');
        document.querySelector('.alert strong').innerHTML = 'Mật khẩu mới phải có ít nhất 6 ký tự';
        return;
    }

    if (old_password.length < 6) {
        document.querySelector('.alert').classList.toggle('alert-danger');
        document.querySelector('.alert strong').innerHTML = 'Mật khẩu cũ phải có ít nhất 6 ký tự';
        return;
    }

    if (new_password !== confirm_password) {
        document.querySelector('.alert').classList.toggle('alert-danger');
        document.querySelector('.alert strong').innerHTML = 'Mật khẩu không khớp nhau';
    } else {
        $.ajax({
            url: './client/auth/resetpassword.php',
            type: 'POST',
            data: {
                password: old_password,
                newpassword: new_password
            },
            success: res => {
                if (res.status == 200) {
                    if (document.querySelector('.alert').classList.contains('alert-danger')) {
                        document.querySelector('.alert').classList.remove('alert-danger');
                    }
                    if (!document.querySelector('.alert').classList.contains('alert-success')) {
                        document.querySelector('.alert').classList.add('alert-success');
                    }
                    document.querySelector('.alert strong').innerHTML = res.message;
                    document.getElementById('old-password').value = '';
                    document.getElementById('password').value = '';
                    document.getElementById('rpassword').value = '';
                } else {
                    if (document.querySelector('.alert').classList.contains('alert-success')) {
                        document.querySelector('.alert').classList.remove('alert-success');
                    }
                    if (!document.querySelector('.alert').classList.contains('alert-danger')) {
                        document.querySelector('.alert').classList.add('alert-danger');
                    }
                    document.querySelector('.alert strong').innerHTML = res.message;
                }
            }
        });
    }
});