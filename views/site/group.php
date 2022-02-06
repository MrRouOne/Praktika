<?php $ai = 0; ?>
<h1 class="text-center" style="margin-top: 40px;">Список студентов группы <?php echo($group); ?></h1>

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
foreach ($students as $student) {
    $ai+=1;
    $id = $student->id;
    $url = app()->route->getUrl("/academic_performance_form?id=$id");
   echo(
    "<div style='margin-top: 20px;'class='d-flex justify-content-between  border-bottom'>".
    "<div class='d-flex'>".
        "<h5>$ai</h5>".
        "<h5 style = 'margin-left: 15px;' ><a class='text-decoration-none' href = '$url'> $student->lastname ".
        "$student->name $student->patronymic </a></h5>".
"</div>".
"<div><h5>01.01.2003</h5></div>".
"</div>");
}
?>


</div>

