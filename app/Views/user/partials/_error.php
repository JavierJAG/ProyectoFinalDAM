<?php if (session('error')) : ?>
    <div class="alert alert-warning alert-dismissible fade show my-4" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>