<h1 class="text-center" style="margin-top: 40px;">Добавить студента</h1>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="d-flex flex-column align-items-center">
        <div style="margin: 10px 0px;" class="mb3 col-8 text-danger"><h3><?= $message ?? ''; ?></h3></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Имя</h3></label>
            <input class="form-control" type="text" name="name"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Фамилия</h3></label>
            <input class="form-control" type="text" name="lastname"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Отчетсво</h3></label>
            <input class="form-control" type="text" name="patronymic"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Дата рождения</h3></label>
            <input class="form-control" type="date" name="date_birth"></div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Пол</h3></label>
            <select class="form-select" name="sex">
                <option selected value="0">Женский</option>
                <option value="1">Мужской</option>
            </select>
        </div>
        <div style="margin-bottom: 30px;" class="mb3 col-8">
            <label class="form-label"><h3>Адрес прописки</h3></label>
            <input class="form-control" type="text" name="address"></div>
        <div class="mb3 col-8">
            <label class="form-label"><h3>Группа</h3></label>
            <select class="form-select" name="students_group">
                <option selected disabled value="">---------</option>
                <?php
                foreach ($groups as $group) {
                    echo "<option value='$group->id'>" . $group->title . '</option>';
                }
                ?>
            </select>


            <button style="margin-top: 50px;" class="btn btn-lg btn-primary ">Отправить</button>
        </div>
    </div>

</form>
