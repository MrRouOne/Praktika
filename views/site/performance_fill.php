<h1 class="text-center" style="margin-top: 40px;">Заполнить упеваемость</h1>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Дисциплина</h3></label>
            <select class="form-select" name="discipline">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($disciplines as $discipline) {
                    echo "<option value='$discipline->id'>" . $discipline->title . '</option>';
                }
                ?>
            </select>
        </div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Студент</h3></label>
            <select class="form-select" name="student">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($students as $student) {
                    echo "<option value='$student->id'>" . $student->name . " " . $student->lastname . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb3 col-8">
            <label class="form-label"><h3>Оценка</h3></label>
            <select class="form-select" name="rate">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($rates as $rate) {
                    echo "<option value='$rate->id'>" . $rate->title . '</option>';
                }
                ?>
            </select>

            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
