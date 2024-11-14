<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card col-12 col-md-6 col-lg-4 shadow-sm p-4">
        <div class="card-body">
            <!-- Header -->
            <div class="text-center mb-4">
                <h3 class="card-title fw-bold">PescadoresDaRia</h3>
                <p class="text-muted"><?= lang('Auth.login') ?></p>
            </div>

            <!-- Error Alerts -->
            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?><br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?= helper(['form', 'reCaptcha']); ?>

            <!-- Login Form -->
            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email Input -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>

                <!-- Password Input -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                </div>

                <!-- reCAPTCHA -->
                <div class="mb-3">
                    <?= reCaptcha2('reCaptcha2', ['id' => 'recaptcha_v2'], ['theme' => 'light']) ?>
                </div>

                <!-- Login Button -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg"><?= lang('Auth.login') ?></button>
                </div>

                <!-- Additional Links -->
                <div class="text-center">
                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <p><a href="<?= url_to('magic-link') ?>" class="text-decoration-none"><?= lang('Auth.forgotPassword') ?> <?= lang('Auth.useMagicLink') ?></a></p>
                    <?php endif ?>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>" class="text-decoration-none"><?= lang('Auth.register') ?></a></p>
                    <?php endif ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
