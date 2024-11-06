<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PescadoresDaRia</title>
    <link rel="stylesheet" href="<?= base_url("/bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">


</head>

<body class="d-flex flex-column min-vh-100">
    <?= view("/user/layout/header") ?>
    <div class="mb-1">
    <?php $this->renderSection('body') ?>
    </div>
   
    <?= view("/user/layout/footer") ?>

    <script src="<?= base_url("/bootstrap/js/bootstrap.min.js") ?>"></script>
</body>

</html>