<?php
/** @var array $movies */
/** @var array $genres */
/** @var array $config */
/** @var array $currentMenuItem */
/** @var string $content */
/** @var string $request */

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Start page</title>
	<link rel="stylesheet" href="resources/styles/start_page.css">
	<link rel="stylesheet" href="resources/styles/reset.css">
</head>
<body>

<div class="wrapper">
	<div class="sidebar">
		<div class="sidebar-header"></div>
		<ul class="menu">
			<li class="menu-item">
				<a href="index.php"
				   class="<?= $currentMenuItem === $config['menu']['main'] ? 'menu-item--active' : ' ' ?>">
					<?= $config['menu']['main'] ?></a>
			</li>
			<?php
			foreach ($genres as $id => $genre): ?>
				<li class="menu-item">
					<a href="index.php?menuItem=<?= $id ?>"
					   class="<?= $currentMenuItem == $id ? 'menu-item--active' : ' ' ?>"><?= $genre ?></a>
				</li>
			<?php
			endforeach; ?>
			<li class="menu-item">
				<a href="index_favorite_movies.php"
				   class="<?= $currentMenuItem === $config['menu']['favorites'] ? 'menu-item--active': ' ' ?>">
					<?= $config['menu']['favorites'] ?></a>
			</li>
		</ul>
	</div>
	<div class="container">
		<?= renderTemplate('./resources/pages/search_page.php',
						   [
							   'request' => $request,
						   ]);
		?>
		<div class="content">
			<?= $content; ?>
		</div>
	</div>
</div>

</body>
</html>