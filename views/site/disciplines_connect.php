<h1 class="text-center" style="margin-top: 40px;">Связать дисциплину</h1>

    <form method="post">
        <div class="d-flex flex-column align-items-center">
            <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
            <div style="margin-bottom: 30px;" class="mb3 col-8">
                <label class="form-label"><h3>Название дисциплины</h3></label>
                <input class="form-control" type="text" name="discipline_title"></div>
            <div style="margin-bottom: 30px;" class="mb3 col-8">
                <label class="form-label"><h3>Учебный план</h3></label>
                <input class="form-control" type="text" name="curriculum"></div>
            <div class="mb3 col-8">
                <label class="form-label"><h3>Количество часов</h3></label>
                <input class="form-control" type="text" name="hours">

                <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
            </div>
        </div>

    </form>
