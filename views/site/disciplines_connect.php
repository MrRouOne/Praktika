<h1 class="text-center" style="margin-top: 40px;">Связать дисциплину</h1>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Название дисциплины</h3></label>
            <select class="form-select" name="discipline_title">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($discipline_titles as $discipline_title) {
                    echo "<option value='$discipline_title->id'>" . $discipline_title->title . '</option>';
                }
                ?>
            </select>
        </div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Учебный план</h3></label>
            <select class="form-select" name="educational_plan">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($educational_plans as $educational_plan) {
                    echo "<option value='$educational_plan->id'>" . $educational_plan->title . '</option>';
                }
                ?>
            </select>
        </div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Количество часов</h3></label>
            <input class="form-control" type="text" name="hours">
        </div>
        <div class="mb3 col-8">
            <label class="form-label"><h3>Тип</h3></label>
            <select class="form-select" name="type">
                <option value="Див зачёт">Див зачёт</option>
                <option value="Экзамен">Экзамен</option>
            </select>

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
