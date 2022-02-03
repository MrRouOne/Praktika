<h1 class="text-center" style="margin-top: 40px;">Заполнить упеваемость</h1>

<form method="post">
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Студент</h3></label>
            <input class="form-control" type="text" name="student"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Дисциплина</h3></label>
            <input class="form-control" type="text" name="discipline"></div>
        <div class="mb3 col-8">
            <label class="form-label"><h3>Оценка</h3></label>
            <input class="form-control" type="text" name="rate">

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
