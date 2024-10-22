<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url("/bootstrap/css/bootstrap.min.css") ?>">

</head>

<body class="d-flex flex-column min-vh-100">
    <?= view("/dashboard/layout/header") ?>
    <?php $this->renderSection('body') ?>
    <?= view("/dashboard/layout/footer") ?>

    <script src="<?= base_url("/bootstrap/js/bootstrap.min.js") ?>"></script>
</body>

</html>