const btnSaveInfo = document.querySelector('.js-save-info');

btnSaveInfo.addEventListener('click', () => {
    document.querySelector('.alert strong').innerHTML = '';

    let email = document.getElementById('email').value;
    let phone = document.getElementById('phone').value;

    if (email == '' || phone == '') {
        if (document.querySelector('.alert').classList.contains('alert-success')) {
            document.querySelector('.alert').classList.remove('alert-success');
        }
        if (!document.querySelector('.alert').classList.contains('alert-danger')) {
            document.querySelector('.alert').classList.add('alert-danger');
        }
        document.querySelector('.alert strong').innerHTML = 'Vui lòng nhập đầy đủ thông tin';
        return;
    }

    let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regexEmail.test(email)) {
        if (document.querySelector('.alert').classList.contains('alert-success')) {
            document.querySelector('.alert').classList.remove('alert-success');
        }
        if (!document.querySelector('.alert').classList.contains('alert-danger')) {
            document.querySelector('.alert').classList.add('alert-danger');
        }
        document.querySelector('.alert strong').innerHTML = 'Email không hợp lệ';
        return;
    }

    let regex = /^(0)[0-9]{9}$/;
    if (!regex.test(phone)) {
        if (document.querySelector('.alert').classList.contains('alert-success')) {
            document.querySelector('.alert').classList.remove('alert-success');
        }
        if (!document.querySelector('.alert').classList.contains('alert-danger')) {
            document.querySelector('.alert').classList.add('alert-danger');
        }
        document.querySelector('.alert strong').innerHTML = 'Số điện thoại không hợp lệ';
        return;
    }

    $.ajax({
        url: './client/auth/changeinfo.php',
        type: 'POST',
        data: {
            email: email,
            phone: phone
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
                document.getElementById('email').value = email;
                document.getElementById('phone').value = phone;
            } else {
                if (document.querySelector('.alert').classList.contains('alert-success')) {
                    document.querySelector('.alert').classList.remove('alert-success');
                }
                if (!document.querySelector('.alert').classList.contains('alert-danger')) {
                    document.querySelector('.alert').classList.add('alert-danger');
                }
                document.querySelector('.alert strong').innerHTML = res.message;
                document.getElementById('email').value = '';
                document.getElementById('phone').value = '';
            }
        }
    });
});