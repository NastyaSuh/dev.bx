
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap core CSS -->
    <link href="/static/bootstrap.min.css" rel="stylesheet">


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
    <!-- Custom styles for this template -->
    <link href="/static/form-validation.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">

    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        </div>


        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Лента сообщений пользователя «<?= $login ?>»</h4>
            <p></p>
            <?php
                if ($messages)
                while ($row = $messages->fetch_assoc()) {
            ?>
                    <div class="card p-2">
                        <p><?= $row['text'] ?></p>
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
