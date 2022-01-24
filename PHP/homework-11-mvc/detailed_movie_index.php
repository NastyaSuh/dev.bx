<?php
declare(strict_types=1);
(error_reporting(-1));

require_once 'autoload.php';
require_once './lib/helpers_functions.php';

$detailedMovie = new DetailedMovieController();
$detailedMovie->renderDetailedMovie();
