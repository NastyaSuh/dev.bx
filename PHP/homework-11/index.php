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
$request = $_GET['request'] ?? "";
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$movies = $database->getMoviesByQuery();
if(empty($movies))
{
	$content = renderTemplate("./resources/pages/movie_not_found.php", [
		'config' => $config]);
}
else
{
	$content = renderTemplate("./resources/pages/movie_card.php", [
		'movies' => $movies]);
}
$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem,
]);
echo $result;