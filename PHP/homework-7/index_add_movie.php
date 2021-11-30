<?php
declare(strict_types=1);
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
$genre = array_key_exists($currentMenuItem, $genres) ? $genres[$currentMenuItem] : '';
$addMovie = isset($_GET['addMovie']);

$request = $_POST['request'] ?? "";

$content = renderTemplate("./resources/pages/add_movie_page.php",
[
	'config' => $config
]);

$result = renderTemplate("./resources/pages/start_page.php", [
	'genres' => $genres,
	'content' => $content,
	'config' => $config,
	'request' => $request,
	'currentMenuItem' => $currentMenuItem,
]);
echo $result;

