<?php

declare(strict_types=1);
/** @var array $movies */
/** @var array $genres */
/** @var array $config */
require_once "data/movies.php";
require_once "./lib/template_functions.php";
require_once "./lib/helpers_functions.php";
require_once "config/app.php";
require_once "./data/database_connect.php";
require_once "./lib/data_base_functions.php";

$database = connectToDataBase($config['dataBase']);
$genres = getGenresFromDB($database);
$movieId = $_GET['movieId'];

$currentMenuItem = $_GET['menuItem'] ?? $config['menu']['main'];
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$request = $_GET['request'] ?? "";
$content = "";

if (isset($_GET['movieId']))
{
	$movieId = (int)$movieId;
	$movie = getMovieById($database, $movieId)[0];
	$actors = getActors($database, $movieId)[0];
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
			'actors' => $actors,
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
