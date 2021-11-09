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

$request = $_GET['request'] ?? "";

$sortedMovie = filterMoviesByGenre($movies, $genre);
$sortedMovie = getMoviesByUserRequest($sortedMovie, $request, $config['search-items']);

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

$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem,
]);
echo $result;