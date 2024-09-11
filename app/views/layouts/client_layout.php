<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Trang chủ" ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= WEB_ROOT . '/public/assets/client/css/grid.css' ?>">
    <?php if (isset($title) && ($title == 'Login' || $title == 'Register')) : ?>
        <link rel="stylesheet" href="<?= WEB_ROOT . '/public/assets/client/css/login.css' ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= WEB_ROOT . '/public/assets/client/css/main.css' ?>">
</head>
<body>
    <div class="app">
        <?php
            $this->view('blocks/client/header', $subcontent);
            $this->view($content, $subcontent);
            $this->view('blocks/client/footer');
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>