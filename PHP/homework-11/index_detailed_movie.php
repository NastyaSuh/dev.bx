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
$actors = $database->getActors();

$movieId = $_GET['movieId'];

$currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('main');
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$request = $_GET['request'] ?? "";
$content = "";

if (isset($_GET['movieId']))
{
	$movieId = (int)$movieId;
	$movie = $database->getMovieById($movieId)[0];
	$actorsById = $database->getActorsById($movieId)[0];
	$directors = $database->getDirectorById($movieId)[0];
	if (!$movie)
	{
		$content = renderTemplate("./resources/pages/movie_not_found.php", [
			'config' => $config,
		]);
	}
	else
	{
		$content = renderTemplate("./resources/pages/detailed_movie.php", [
			'movie' => $movie,
			'actorsById' => $actorsById,
			'directors' => $directors
		]);
	}
}

$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem,
]);
echo $result;