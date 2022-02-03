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
    <title>Pop it MVC</title>
</head>
<body>
<div class="container-fluid p-0">
    <div class="d-flex flex-md-row p-3 px-md-4 mb-3 bg-white border-bottom box-shadow justify-content-md-between align-items-center" style="padding: 0 100px;">
        <h1 class="mr-md-auto p-2">Деканат</h1>
        <?php
        if (!app()->auth::check()):
            ?>
            <a class="btn btn-primary" href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php
        else:
            ?>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= app()->auth::user()->name ?>
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        <?php
        endif;
        ?>

    </div>

</div>


<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>

    </nav>
</header>
<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>