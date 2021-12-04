<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>

    <link href="static/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <link href="static/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<form class="form-signin" method="post" action="index.php">
    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
    <label for="inputEmail" class="sr-only">Логин</label>
    <input
           title="Допускаются только симовлы латинского алфавита и цифры, длина от 3 до 15"
           type="text" name="login" pattern="[A-Za-z0-9]{3,15}" id="inputEmail" class="form-control" placeholder="login" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control"  name="pass" placeholder="password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="action" value="login">Войти</button>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="action" value="reg">Зарегистрироваться</button>
</form>
</body>
</html>
