<h1 class="text-center" style="margin-top: 40px;">Успеваемость
    студента <?php echo("$student->lastname $student->name"); ?></h1>

<div style="margin-top: 50px;" class="d-flex flex-column">
    <h3><a href="<?php echo(app()->route->getUrl("/academic_performance_form?id=$student->id")); ?>">Указать курс и семестр</a></h3>
</div>

<div style="margin-top: 50px;" class="d-flex flex-column">
    <div class="d-flex justify-content-between">
        <div><h5>Наименование</h5></div>
        <div class="d-flex">
            <h5 style="margin-right: 85px;">кол-во часов</h5>
            <h5>Оценка</h5>
        </div>
    </div>
</div>




<?php

use Model\Discipline_title;
use Model\Rate;
use Model\Academic_performance;

if (!empty($disciplines)) {
    foreach ($disciplines as $discipline) {
        $id = $student->id;
        $url = app()->route->getUrl("/performance_discipline?id=$discipline->id");
        $name = Discipline_title::where('id', $discipline['discipline_title'])->first()['title'];
        $rate = Rate::where('id', Academic_performance::where(['discipline' => $discipline->id, 'student' => $id])->first()['rate'])->first()['title'];
        if(!empty($name) and !empty($discipline->hours) and !empty($rate)) {
            echo(
                "<div style='margin-top: 20px;' class='d-flex flex-column border-bottom'>" .
                "<div class='d-flex justify-content-between'>" .
                "<div><h5><a class='text-decoration-none' href='$url'>$name</a></h5></div>" .
                "<div class='d-flex'>" .
                "<h5 style='margin-right: 160px;'>$discipline->hours</h5>" .
                "<h5>$rate</h5>" .
                "</div>" .
                "</div>" .
                "</div>");
        }
    }
}

?>
</div>



