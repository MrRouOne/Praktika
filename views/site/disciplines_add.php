<h1 class="text-center" style="margin-top: 40px;">Добавить дисциплину</h1>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-top: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Название дисциплины</h3></label>
            <input class="form-control" type="text" name="title">

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
