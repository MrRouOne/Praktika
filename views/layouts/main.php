<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <title>Деканат</title>
</head>
<body>
<div class="container-fluid p-0">
    <div class="d-flex flex-md-row p-3 px-md-4 mb-3 bg-white border-bottom box-shadow justify-content-md-between align-items-center">
        <h1 class="mr-md-auto p-2" style="margin-left: 100px;"><a class="text-decoration-none"
                                                                  href="<?= app()->route->getUrl('/') ?>">Деканат</a></h1>
        <?php use Model\User;
        if (!app()->auth::check()):
            ?>
            <a style="margin-right: 100px;" class="btn btn-lg btn-primary" href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php
        else:
            ?>
            <?php
            if (User::checkRoleCurrent('admin')):
                ?>
                <div class="dropdown text-end">
                    <a style="margin-right: 100px;" href="#"
                       class="d-block link-dark text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= app()->auth::user()->name; ?>  <?= app()->auth::user()->lastname; ?>
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/users_add') ?>">Добавить
                                пользователя</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/disciplines_add') ?>">Добавить
                                дисциплину</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/group_add') ?>">Добавить
                                группу студентов</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/student_add') ?>">Добавить
                                студента</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/logout') ?>">Выход</a></li>
                    </ul>
                </div>
            <?php
            elseif (User::checkRoleCurrent('staff')):
                ?>
                <div class="dropdown text-end">
                    <a style="margin-right: 100px;" href="#"
                       class="d-block link-dark text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= app()->auth::user()->name; ?>  <?= app()->auth::user()->lastname; ?>
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/disciplines_connect') ?>">Связать
                                дисциплину</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/performance_fill') ?>">Заполнить
                                успеваемость</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/curriculums_add') ?>">Учебный план</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/logout') ?>">Выход</a></li>
                    </ul>
                </div>
            <?php
            elseif (User::checkRoleCurrent('curator')):
                ?>
                <div class="dropdown text-end">
                    <a style="margin-right: 100px;" href="#"
                       class="d-block link-dark text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= app()->auth::user()->name; ?>  <?= app()->auth::user()->lastname; ?>
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/group') ?>">Группы</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/disciplines_list_form') ?>">Дисциплины</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/send_report') ?>">Отправить отчёт</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/logout') ?>">Выход</a></li>
                    </ul>
                </div>
            <?php
            endif;
            ?>
        <?php
        endif;
        ?>

    </div>
    <div class="container">
        <main>
            <?= $content ?? '' ?>
        </main>
    </div>

</div>
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top"
        style="margin-top: 100px; height: 200px;">
    <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>
        <h4 class="text-muted">© 2022 Dekanat</h4>
    </div>
</footer>

</body>
</html>