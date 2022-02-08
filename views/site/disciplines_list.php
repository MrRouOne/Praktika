<h1 class="text-center" style="margin-top: 40px;">Список дисциплин группы 492</h1>

<div style="margin-top: 50px;" class="d-flex flex-column">
    <div class="d-flex justify-content-between">
        <h5>Наименование</h5>
        <h5>кол-во часов</h5>
    </div>
</div>

<?php

use Model\DisciplineTitle;

if (!empty($disciplines)) {
    foreach ($disciplines as $discipline) {
        $id = $discipline->id;
        $url = app()->route->getUrl("/performance_discipline?id=$id");
        $name = DisciplineTitle::where('id', $discipline->discipline_title)->first()['title'];
        if(!empty($name)) {
            echo(
                "<div style='margin-top: 20px;' class='d-flex flex-column border-bottom'>" .
                "<div class='d-flex justify-content-between'>" .
                "<h5><a class='text-decoration-none' href='$url'>$name</a></h5>" .
                "<h5>$discipline->hours</h5>" .
                "</div>" .
                "</div>");
        }
    }
}

?>

</div>


