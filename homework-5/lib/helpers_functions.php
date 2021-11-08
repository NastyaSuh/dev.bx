<?php

function formatDescription(string $description): string
{
	return mb_strimwidth($description, 0, 150, "...");
}

function formatTitle(string $title): string
{
	return mb_strimwidth($title, 0, 25, "...");
}

function formatDuration(int $duration): string
{
	$hours = (int)($duration / 60);
	$minutes = $duration - $hours * 60;

	$h = str_pad((string)$hours, 2, "0", STR_PAD_LEFT);
	$m = str_pad((string)$minutes, 2, "0", STR_PAD_LEFT);

	return "$duration мин./ $h.$m";
}

function formatRating(float $rating): string
{
	return str_pad((string)$rating, 3, ".0", STR_PAD_RIGHT);;
}

function printGenre(array $genres): string
{
	return implode(', ', $genres);
}

function sortMoviesByGenre(array $movies, string $genre = ""): array
{
	if ($genre === "")
	{
		return $movies;
	}

	$sortedMoviesByGenre = [];

	foreach ($movies as $movie)
	{
		if (in_array($genre, $movie['genres']))
		{
			$sortedMoviesByGenre[] = $movie;
		}
	}

	return $sortedMoviesByGenre;
}

function sortMoviesByID(array $movies, int $id)
{
	foreach ($movies as $movie)
	{
		if ($movie['id'] === $id)
		{
			return $movie;
		}
	}

	return false;
}

function contains(string $line, string $substring): bool
{
	return strpos($line, $substring) !== false;
}

function mergeMovie(array $movies, array $search_items): string
{
	$mergedMovie = "";
	foreach ($movies as $key => $movie)
	{
		if (!in_array($key, $search_items))
		{
			continue;
		}
		if (is_string($movie))
		{
			$mergedMovie .= $movie;
		}
		elseif (is_array($movie))
		{
			$mergedMovie .= implode($movie);
		}
	}

	return mb_strtolower($mergedMovie);
}

function sortMoviesByUserRequest(array $movies, string $request, array $search_items): array
{
	if ($request === "")
	{
		return $movies;
	}

	$sortedMovies = [];
	$request = mb_strtolower($request); //приводим к нижнему регистру

	foreach ($movies as $movie)
	{
		//если $request находится в movie, тогда sortedMovies = movie
		if (contains(mergeMovie($movie, $search_items), $request))
		{
			$sortedMovies[] = $movie;
		}
	}

	return $sortedMovies;
}