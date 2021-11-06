<?php
function formatDescription(string $description):string
{
	return mb_strimwidth($description, 0, 150, "...");
}
function formatTitle(string $title):string
{
	return mb_strimwidth($title, 0, 25, "...");
}
function formatDuration(int $duration):string
{
	$hours = (int)($duration / 60);
	$minutes = $duration - $hours * 60;

	$h = str_pad((string)$hours, 2, "0", STR_PAD_LEFT);
	$m = str_pad((string)$minutes, 2, "0", STR_PAD_LEFT);
	return "$duration мин./ $h.$m";
}
function formatRating(float $rating):string
{
	return  str_pad((string)$rating, 3, ".0", STR_PAD_RIGHT);;
}
function printGenre(array $genres):string
{
	return implode(', ', $genres);
}
function sortMoviesByGenre(array $movies, string $genre = ""):array
{
	if($genre === "")
	{
		return $movies;
	}

	$sortedMoviesByGenre = [];

	foreach ($movies as $movie)
	{
		if(in_array($genre, $movie['genres']))
		{
			$sortedMoviesByGenre[] = $movie;
		}
	}
	return $sortedMoviesByGenre;
}
function sortMoviesByID(array $movies, int $id):array
{
	foreach ($movies as $movie)
	{
		if($movie['id'] === $id)
		{
			return $movie;
		}
	}
	$nullResult =[
		'id' => 0,
		'title' => '',
		'original-title' => '',
		'description' => '',
		'duration' => 0,
		'genres' => [],
		'cast' => [],
		'director' => '',
		'age-restriction' => 0,
		'release-date' => 0,
		'rating' => 0
	];
	return $nullResult;
}

// function contains(string $line, string $substring):bool
// {
// 	return strpos($line, $substring);
// }
//
// function implodeMovie(array $movie):string
// {
// 	$movieImploded = "";
// 	foreach ($movie as $key => $film)
// 	{
// 		if ($key === 'id')
// 		{
// 			continue;
// 		}
// 		if (is_array($film))
// 		{
// 			$movieImploded .= implode($film);
// 		}
// 	}
// 	return mb_strtolower($movieImploded);
// }
//
// function sortMovieByUserRequest(array $movies, string $request = ""):array
// {
// 	$sortedMovies = [];
// 	if($request === "")
// 	{
// 		return $movies;
// 	}
// 	$request = mb_strtolower($request);
// 	foreach ($movies as $movie)
// 	{
// 		//если содержится $request, то $sortedMovies =  $movie;
// 		if(contains(implodeMovie($movie), $request))
// 		{
// 			$sortedMovies = $movie;
// 		}
// 	}
//
// 	return $sortedMovies;
// }
