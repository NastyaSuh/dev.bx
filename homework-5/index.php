<?php
declare(strict_types=1);
/** @var array $movies */
/** @var array $genres */
/** @var array $config */
require_once "data/movies.php";
require_once "./lib/template_functions.php";
require_once "./lib/helpers_functions.php";
require_once "config/app.php";

$currentMenuItem = $_GET['menuItem'] ?? $config['menu']['main'];
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$addMovie = isset($_GET['addMovie']);

$request = $_GET['request'] ?? "";

if (isset($_GET['id']))
{
	$id = (int)$_GET['id'];
	$sortedMovieByID = sortMoviesByID($movies, $id);
	if ($sortedMovieByID)
	{
		$content = renderTemplate("./resources/pages/detailed_movie.php", [
			'movie' => $sortedMovieByID,
		]);
	}
	else
	{
		$content = renderTemplate("./resources/pages/movieNotFound.php", [
			'config' => $config,
		]);
	}
}

else
{
	$sortedMovie = sortMoviesByGenre($movies, $genre);
	$sortedMovie = sortMoviesByUserRequest($sortedMovie, $request, $config['search-items']);

	if (!empty($sortedMovie))
	{
		$content = renderTemplate("./resources/pages/movie_card.php", [
			'movies' => $sortedMovie,
		]);
	}

	else
	{
		$content = renderTemplate("./resources/pages/movie_not_found.php", [
			'config' => $config,
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
