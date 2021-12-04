<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <link href="static/form-validation.css" rel="stylesheet">
</head>

<?php

if ($is_admin){
    ?> <img src="static/menu.png" style="width: 100%">
    <?php

}
?>

<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">

    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <div class="card p-2">
            <h4>Привет, <?= $user['login'] ?>!</h4>
            <p>Вы <?= $is_admin ? '' : 'не '  ?>админ. <a style="float: right" href="./?action=logout">Выход</a></p>

            <h4 class="mb-3">Ваш баланс: <?= (int)$user['balance'] ?> cr</h4>

            <?php if (! (int)$user['bonus_used'] ) { ?>
                <p>Спасибо за регистрацию. Вы можете <a href="./?action=getbonus">получить</a> бонус 100 cr</p>
            <?php } else { ?>
                <p>Вы уже получили бонус</p>
            <?php } ?>
            </div>

            <br>

            <form enctype="multipart/form-data" class="card p-2" method="POST" action="./">
                <h4>Настройка профиля</h4>
                <img style="width: 100%" src="<?= $user['photo'] ? : './static/nophoto.jpg' ?>">
                <br>
                <input required type="file" name="photo" placeholder="photo" accept="image/jpeg,image/png,image/gif"><br>
                <button type="submit" class="btn btn-secondary" name="action" value="uploadphoto">Загрузить фото</button>
            </form>
            <br>

            <form enctype="multipart/form-data" class="card p-2" method="POST" action="./">
                <h4>Смена пароля</h4>
                <input  type="hidden" name="id" value="<?= $user['id'] ?>">
                <input required type="password" name="pass" placeholder="Новый пароль"><br>
                <button type="submit" class="btn btn-secondary" name="action" value="changepass">Cменить пароль</button>
            </form>
            <br>

            <form class="card p-2" method="POST" action="./">
                <h4>Перевод средств</h4>
                <input type="number" name="sum" value="" placeholder="Сумма перевода" accept="image/jpeg,image/png,image/gif"><br>
                <select name="to">
                    <option value="" disabled>Получатель</option>
                    <?php
                       while ($row = $users->fetch_assoc()) {?>
                        <option value="<?= htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['login']) ?></option>
                    <?php } ?>
                </select>
                <br>
                <button type="submit" class="btn btn-secondary" name="action" value="sendcr">Отправить</button>
            </form>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Форум</h4>
            <p>Добавить сообщение</p>
            <form class="card p-2" method="POST" action="./" accept-charset="UTF-8">
                <textarea name="msg"></textarea><br>
                <button type="submit" class="btn btn-secondary" name="action" value="addmessage">Отправить</button>
            </form>
            <br>
            <?php
                while ($row = $messages->fetch_assoc()) {
            ?>
                    <div class="card p-2">
                        <h4><?= $row['login'] ?> написал:</h4>
                        <p><?= htmlspecialchars($row['text']) ?></p>
                        <p><a href="./?page=feed.html&id=<?= $row['id'] ?>">Подписаться автора</a></p>
                    </div>
                    <br>
            <?php
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>
