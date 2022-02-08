<h1 class="text-center" style="margin-top: 40px;">Успеваемость студентов по дисциплине
    <?php use Model\DisciplineTitle;
    $name = DisciplineTitle::find($discipline['discipline_title'])->title;
    echo("$name"); ?></h1>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?php echo($_REQUEST['message'] ?? ''); ?></h3>
        </div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h1>Выберите курс и семестр</h1></label>
        </div>
        <div style="margin-bottom: 50px;" class="mb3 col-8">
            <label class="form-label"><h3>Курс</h3></label>
            <input class="form-control" type="text" name="course"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Семестр</h3></label>
            <input class="form-control" type="text" name="semester">

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>


</div>

