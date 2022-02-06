<?php $ai = 0; ?>
<h1 class="text-center" style="margin-top: 40px;">Успеваемость студентов по дисциплине
    <?php use Model\Discipline_title;
    $name = Discipline_title::where('id', $discipline['discipline_title'])->first()['title'];
    echo("$name"); ?></h1>

<div style="margin-top: 50px;" class="d-flex flex-column">
    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <h5>№</h5>
            <h5 style="margin-left: 10px;">ФИО</h5>
        </div>
        <div><h5>Оценка</h5></div>
    </div>
</div>


<?php

use Model\Rate;
use Model\Academic_performance;

if (!empty($students)) {
    foreach ($students as $student) {
        $ai+=1;
        $id = $student->id;
        $url = app()->route->getUrl("/academic_performance_form?id=$id");
        $rate = Rate::where('id', Academic_performance::where(['discipline' => $discipline->id, 'student' => $id])->first()['rate'])->first()['title'];
        if(!empty($rate)) {
            echo(
                "<div style='margin-top: 20px;' class='d-flex justify-content-between border-bottom'>" .
                "<div class='d-flex'>" .
                "<h5>$ai</h5>" .
                "<h5 style='margin-left: 15px;'><a class='text-decoration-none' href='$url'>$student->name $student->lastname $student->patronymic </a></h5>".
                "</div>" .
                "<div><h5>$rate</h5></div>" .
                "</div>");
        }
    }
}

?>

</div>

