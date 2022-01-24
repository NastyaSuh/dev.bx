<?php
declare(strict_types=1);
(error_reporting(-1));

require_once "./lib/render.php";
require_once "./lib/helpers_functions.php";
require_once "classes/Frameworks/Config.php";
require_once "classes/Frameworks/DatabaseConnectionSettings.php";
require_once "classes/Frameworks/MoviesFromDatabase.php";
require_once "classes/Frameworks/DefaultTitles.php";

$config = new Config();
$database = new MoviesFromDatabase($config->getDatabaseConnectionItem());
$genres = $database->getGenres();
$currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('main');
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$addMovie = isset($_GET['addMovie']);

$request = $_POST['request'] ?? "";

$content = renderTemplate("./resources/pages/favorite_movie_page.php", [
	'config' => $config,
]);

$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $config['menu']['favorites'],
]);
echo $result;