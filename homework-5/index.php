<?php
declare(strict_types = 1);
/** @var array $movies */
/** @var array $genres */
/** @var array $config */
require_once "data/movies.php";
require_once "./lib/template_functions.php";
require_once "./lib/helpers_functions.php";
require_once "config/app.php";

$currentMenuItem = $_GET['menuItem']??'Главное';
$genre = array_key_exists($currentMenuItem, $genres)? $genres[$currentMenuItem] : '';
$addMovie = isset($_GET['addMovie']);

$request = $_POST['request'] ?? '';

if(isset($_GET['id']))
{
	$id = (int)$_GET['id'];
	$sortedMovieByID = sortMoviesByID($movies, $id);
	$content = renderTemplate("./resources/pages/detailedMovie.php",
	[
		'movie'=> $sortedMovieByID
	]);
}
elseif($currentMenuItem === $config['menu']['favorites'])
{
	$content = renderTemplate("./resources/pages/favoriteMovie.php",
	[
		'config' => $config
	]);
}
elseif($addMovie)
{
	$content = renderTemplate("./resources/pages/addMovie.php",
	 [
		 'config' => $config
	]);
}
else
{
	$sortedMovie = sortMoviesByGenre($movies, $genre);
	// $sortedMovie = sortMovieByUserRequest($sortedMovie, $request);
	//
	// if(empty($sortedMovie))
	// {
	// 	//отрисовка страницы с текстом "по вашему запросу фильмов не найдено"
	// 	$content = renderTemplate("./resources/pages/movieNotFound.php", [
	// 		'config' => $config
	// 	]);
	// }
	// else
	// {
		$content = renderTemplate("./resources/pages/movieCard.php", [
			'movies' => $sortedMovie
		]);
	// }
}

$result = renderTemplate("./resources/pages/startPage.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem
]);
echo $result;


