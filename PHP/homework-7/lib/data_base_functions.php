<?php

function getGeneralQuery(): string
{
	return "SELECT movie.ID as id, movie.TITLE as title, movie.ORIGINAL_TITLE as 'original-title',
					movie.DESCRIPTION as description, movie.DURATION as duration,
                    movie.AGE_RESTRICTION as 'age-restriction', movie.RELEASE_DATE as 'release-date', movie.RATING as rating,
					 (
				          SELECT GROUP_CONCAT(actor.NAME)
				          FROM actor 
				          INNER JOIN movie_actor ma on actor.ID = ma.ACTOR_ID
				          WHERE ma.MOVIE_ID = movie.ID
				        ) as actors,					      
                    ( 
				          SELECT GROUP_CONCAT(genre.NAME)
				          FROM genre 
				          INNER JOIN movie_genre mg on genre.ID = mg.GENRE_ID
				          WHERE mg.MOVIE_ID = movie.ID
                    ) as genres
					FROM movie
					INNER JOIN director d on movie.DIRECTOR_ID = d.ID 
					";
}

function getGenresFromDB(mysqli $database): array
{
	$genres = [];
	$query = "SELECT CODE, NAME FROM dev.genre";
	$result = mysqli_query($database, $query);
	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}
	while ($row = mysqli_fetch_assoc($result))
	{
		$genreId = $row['CODE'];
		$genreName = $row['NAME'];
		$genres[$genreId] = $genreName;
	}

	return $genres;
}

function getMoviesFromDB(mysqli $database, array $genres, string $codeGenre = ""): array
{
	$movies = [];
	$query1 = getGeneralQuery();

	if ($codeGenre == "")
	{
		$result = mysqli_query($database, $query1);
	}

	else
	{
		$query2 = $query1 . "INNER JOIN movie_genre m on movie.ID = m.MOVIE_ID
					INNER JOIN genre g on m.GENRE_ID = g.ID
					WHERE g.NAME = '$codeGenre'
					";
		$result = mysqli_query($database, $query2);
	}

	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$movies[] = $row;
	}

	return $movies;
}

function getMovieById(mysqli $database, int $movieId): array
{
	$movie = [];
	$generalQuery = getGeneralQuery();
	$movieIdQuery = $generalQuery . "WHERE movie.ID = $movieId";
	$result = mysqli_query($database, $movieIdQuery);
	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}
	while ($row = mysqli_fetch_assoc($result))
	{
		$movie[] = $row;
	}
	return $movie;
}

function getActors(mysqli $database, int $movieId): array
{
	$actors = [];
	$query = "SELECT
		(
			SELECT GROUP_CONCAT(actor.NAME SEPARATOR ', ')
			FROM actor 
			INNER JOIN movie_actor ma on actor.ID = ma.ACTOR_ID
			WHERE ma.MOVIE_ID = movie.ID
        ) as actors,
        (
            SELECT director.NAME
			FROM director 
			INNER JOIN movie m on director.ID = m.DIRECTOR_ID
			WHERE director.ID = movie.DIRECTOR_ID
         GROUP BY director.ID
        ) as director
		FROM movie
		where movie.ID = $movieId";

	$result = mysqli_query($database, $query);
	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}
	while ($row = mysqli_fetch_assoc($result))
	{
		$actors[] = $row;
	}
	return $actors;
}


