<?php
declare(strict_types=1);
(error_reporting(-1));
/** @var array $movies */
/** @var array $genres */
/** @var array $config */
require_once "./lib/template_functions.php";
require_once "./lib/helpers_functions.php";
require_once "config/app.php";
require_once "./data/database_connect.php";
require_once "./lib/data_base_functions.php";

$database = connectToDataBase($config['dataBase']);
$genres = getGenresFromDB($database);
$currentMenuItem = $_GET['menuItem'] ?? $config['menu']['main'];
$request = $_GET['request'] ?? "";

$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$movies = getMoviesFromDB($database, $config['search-items'], $request, $genre);
if(empty($movies))
{
	$content = renderTemplate("./resources/pages/not_found.php", [
		'config' => $config
	]);
}
else
{
	$content = renderTemplate("./resources/pages/movie_card.php", [
		'movies' => $movies,
	]);
}

$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem,
]);
echo $result;

//если есть id фильма, можем переходить в подробную информацию о нем, если нет, тогда переходим по жанрам в боковом меню
//переходим по жанрам в боковом меню
//мы получили список фильмов из бд => если !$movies тогда вызываем заглушку, если нет, то вызывает movie_card