<?php $ai = 0; ?>
<h1 class="text-center" style="margin-top: 40px;">Список студентов группы <?php echo($group); ?></h1>

<form method="get">
    <div style="margin-top: 40px;" class="mb3 col-8">
        <div class="d-flex align-items-center">
            <label style="margin-right: 20px;" class="form-label"><h3>Поиск по фамилии</h3></label>
            <input class="form-control" type="text" name="lastname">

            <button style="margin-left: 20px;" class="btn btn-primary ">Отправить</button>
        </div>
    </div>

</form>

<div style="margin-top: 50px;" class="d-flex flex-column">
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <h5>№</h5>
            <h5 style="margin-left: 10px;">ФИО</h5>
        </div>
        <div><h5>дд.мм.гггг</h5></div>
    </div>
</div>

<?php
date_default_timezone_set('Etc/GMT-7');
foreach ($students as $student) {
    $ai += 1;
    $id = $student->id;
    $url = app()->route->getUrl("/academic_performance_form?id=$id");
    $date = date("d.m.Y", strtotime($student->date_birth));
    echo(
        "<div style='margin-top: 20px;'class='d-flex justify-content-between  border-bottom'>" .
        "<div class='d-flex'>" .
        "<h5>$ai</h5>" .
        "<h5 style = 'margin-left: 15px;' ><a class='text-decoration-none' href = '$url'> $student->lastname " .
        "$student->name $student->patronymic </a></h5>" .
        "</div>" .
        "<div><h5>$date</h5></div>" .
        "</div>");
}
?>


</div>

