<h1 class="text-center" style="margin-top: 40px;">Добавить группу студентов</h1>

<form method="post">
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Номер группы</h3></label>
            <input class="form-control" type="text" name="title"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Курс</h3></label>
            <input class="form-control" type="text" name="course"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Семестр</h3></label>
            <input class="form-control" type="text" name="semester"></div>
        <div class="mb3 col-8">
            <label class="form-label"><h3>Куратор</h3></label>
            <input class="form-control" type="text" name="user">

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
