<h1 class="text-center" style="margin-top: 40px;">Авторизация</h1>



<?php
if (!app()->auth::check()):
    ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="d-flex flex-column align-items-center">
            <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
            <div style="margin-bottom: 30px;" class="mb3 col-8">
                <label class="form-label"><h3>Логин</h3></label>
                <input class="form-control" type="text" name="login"></div>
            <div class="mb3 col-8">
                <label class="form-label"><h3>Пароль</h3></label>
                <input class="form-control" type="password" name="password">

                <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Войти</button>
            </div>
        </div>

    </form>
<?php endif;
