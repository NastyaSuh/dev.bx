<?php

function getGeneralQuery(): string
{
	return "SELECT movie.ID as id, movie.TITLE as title, movie.ORIGINAL_TITLE as 'original-title',
					movie.DESCRIPTION as description, movie.DURATION as duration,
                    movie.AGE_RESTRICTION as 'age-restriction', movie.RELEASE_DATE as 'release-date', 
                    movie.RATING as rating, d.NAME as 'director',					      
                    ( 
				          SELECT GROUP_CONCAT(mg.GENRE_ID)
				          FROM movie_genre mg 
				          WHERE mg.MOVIE_ID = movie.ID
                    ) as genres,
                    (
                        SELECT GROUP_CONCAT(ma.ACTOR_ID)
						FROM movie_actor ma 
						WHERE ma.MOVIE_ID = movie.ID
					) as actors
					FROM movie
					INNER JOIN director d on movie.DIRECTOR_ID = d.ID 
					";
}

function getGenresFromDB(mysqli $database): array
{
	$genres = [];
	$query = "SELECT ID, NAME FROM dev.genre";
	$result = mysqli_query($database, $query);
	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}
	while ($row = mysqli_fetch_assoc($result))
	{
		$genreId = $row['ID'];
		$genreName = $row['NAME'];
		$genres[$genreId] = $genreName;
	}

	return $genres;
}

function getActorsFromDB(mysqli $database): array
{
	$actors = [];
	$query = "SELECT ID, NAME FROM actor";
	$result = mysqli_query($database, $query);
	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}
	while ($row = mysqli_fetch_assoc($result))
	{
		$actorId = $row['ID'];
		$actorName = $row['NAME'];
		$actors[$actorId] = $actorName;
	}

	return $actors;
}

//для поиска просто модифицирую функцию по получению фильмов из БД
//доп-о передаю туда параметры поиска и запрос
//если код жанра пустой, тогда вызываю $result = mysqli_query($database, $query1);
//если строка запроса не пустая, тогда ищу по параметрам из конфига

function getMoviesFromDB(
	mysqli $database,
	array  $searchParameters,
	array  $genres,
	string $request = "",
	string $codeGenre = ""
): array
{
	$movies = [];
	$query1 = getGeneralQuery();
	$searchField = implode(',', $searchParameters);
	if ($codeGenre != "")
	{
		$query1 .= "INNER JOIN movie_genre m on movie.ID = m.MOVIE_ID
					INNER JOIN genre g on m.GENRE_ID = g.ID
					WHERE g.NAME = '$codeGenre'
					";
	}

	if ($request != "")
	{
		$query1 = "SELECT * FROM ($query1) as query1 WHERE CONCAT($searchField) like ?";
	}

	$preparedStatement = mysqli_prepare($database, $query1);

	$usingQuery = $request !== "";

	if ($usingQuery)
	{
		$request = "%$request%";
		mysqli_stmt_bind_param($preparedStatement, "s", $request);
	}

	$executeResult = mysqli_stmt_execute($preparedStatement);

	if (!$executeResult)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}

	$result = mysqli_stmt_get_result($preparedStatement);

	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$genresId = explode(',', $row['genres']);
		$row['genres'] = convertArrayFromIdsToNames($genres, $genresId);
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

function getActorsById(mysqli $database, array $actors, int $movieId): array
{
	$actorsById = [];
	$query = getGeneralQuery();
	$query .= "where movie.ID = $movieId";
	$result = mysqli_query($database, $query);

	if (!$result)
	{
		$error = mysqli_errno($database) . ":" . mysqli_error($database);
		trigger_error($error);
	}

	while ($row = mysqli_fetch_assoc($result))
	{
		$actorsId = explode(',', $row['actors']);
		$row['actors'] = convertArrayFromIdsToNames($actors, $actorsId);
		$actorsById[] = $row;
	}

	return $actorsById;
}

function getDirectorById(mysqli $database, int $movieId): array
{
	$directors = [];
	$query = "SELECT
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
		$directors[] = $row;
	}

	return $directors;
}