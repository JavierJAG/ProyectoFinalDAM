<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PescadoresDaRia</title>
    <link rel="stylesheet" href="<?= base_url("/bootstrap/css/bootstrap.min.css") ?>">

</head>

<body class="d-flex flex-column min-vh-100">
    <?php if(auth()->isLoggedIn()) : ?>
    <?= view("/user/layout/header") ?>
    <?php else :?>
    <?= view("/web/layout/header") ?>
    <?php endif ?>
    <?php $this->renderSection('body') ?>
    <?php if(auth()->isLoggedIn()) : ?>
    <?= view("/user/layout/footer") ?>
    <?php else :?>
    <?= view("/web/layout/footer") ?>
    <?php endif ?>

    <script src="<?= base_url("/bootstrap/js/bootstrap.min.js") ?>"></script>
</body>

</html>