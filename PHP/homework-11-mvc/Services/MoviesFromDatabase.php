<?php

class MoviesFromDatabase
{
	private mysqli $database;
	private array $genres;
	private array $actors;

	public function __construct(DatabaseConnectionSettings $settings)
	{

		$this->connectToDataBase($settings);
		$this->genres = $this->getGenres();
		$this->actors = $this->getActors();
	}

	private function connectToDatabase(DatabaseConnectionSettings $settings):void
	{
		$this->database = mysqli_init();
		$dbConnect = $this->database->real_connect($settings->getHost(), $settings->getUsername(),
												   $settings->getPassword(), $settings->getDatabaseName());
		$dbChangeEncoding = mysqli_set_charset($this->database, "utf8mb4");
		$error = mysqli_errno($this->database). ":" .mysqli_error($this->database);
		if(!$dbConnect || !$dbChangeEncoding)
		{
			trigger_error($error);
		}
	}

	private function getGeneralQuery(): string
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

	public function getActors(): array
	{
		$actors = [];
		$query = "SELECT ID, NAME FROM actor";
		$result = mysqli_query($this ->database, $query);
		if (!$result)
		{
			$error = mysqli_errno($this ->database) . ":" . mysqli_error($this ->database);
			trigger_error($error);
		}
		while ($row = mysqli_fetch_assoc($result))
		{
			$actors[] = new Actor($row);
		}
		return $actors;
	}

	// ?=мб ноль мб нет

	public function getGenres(): array
	{
		$genres = [];
		$query = "SELECT ID, CODE, NAME FROM dev.genre";
		$result = mysqli_query($this->database, $query);
		if (!$result)
		{
			$error = mysqli_errno($this->database) . ":" . mysqli_error($this->database);
			trigger_error($error);
		}
		while ($row = mysqli_fetch_assoc($result))
		{
			$genres[] = new Genre($row);
		}
		return $genres;
	}

	public function getMoviesByQuery(string $request = "", string $codeGenre = ""): array
	{
		$movies = [];
		$query1 = $this->getGeneralQuery();
		$searchItems = implode(',', Config::getSearchItem());
		if ($codeGenre != "")
		{
			$query1 .= "INNER JOIN movie_genre m on movie.ID = m.MOVIE_ID
					INNER JOIN genre g on m.GENRE_ID = g.ID
					WHERE g.NAME = '$codeGenre'
					";
		}

		if ($request != "")
		{
			$query1 = "SELECT * FROM ($query1) as query1 WHERE CONCAT($searchItems) like ?";
		}

		$preparedStatement = mysqli_prepare($this -> database, $query1);

		$usingQuery = $request !== "";

		if ($usingQuery)
		{
			$request = "%$request%";
			mysqli_stmt_bind_param($preparedStatement, "s", $request);
		}

		$executeResult = mysqli_stmt_execute($preparedStatement);

		if (!$executeResult)
		{
			$error = mysqli_errno($this -> database) . ":" . mysqli_error($this -> database);
			trigger_error($error);
		}

		$result = mysqli_stmt_get_result($preparedStatement);

		if (!$result)
		{
			$error = mysqli_errno($this -> database) . ":" . mysqli_error($this -> database);
			trigger_error($error);
		}

		while ($row = mysqli_fetch_assoc($result))
		{
			$movies[] = new Movie($row);
		}
		return $movies;
	}

	public function getMovieById(int $movieId): array
	{
		$movie = [];
		$generalQuery = $this -> getGeneralQuery();
		$movieIdQuery = $generalQuery . "WHERE movie.ID = $movieId";
		$result = mysqli_query($this -> database, $movieIdQuery);
		if (!$result)
		{
			$error = mysqli_errno($this -> database) . ":" . mysqli_error($this -> database);
			trigger_error($error);
		}
		while ($row = mysqli_fetch_assoc($result))
		{
			$movie[] = $row;
		}
		return $movie;
	}

	public function getActorsById(int $movieId): array
	{
		$actorsById = [];
		$query = $this -> getGeneralQuery();
		$query .= "where movie.ID = $movieId";
		$result = mysqli_query($this -> database, $query);
		if (!$result)
		{
			$error = mysqli_errno($this -> database) . ":" . mysqli_error($this -> database);
			trigger_error($error);
		}

		while ($row = mysqli_fetch_assoc($result))
		{
			$actorsId = explode(',', $row['actors']);
			$row['actors'] = convertArrayFromIdsToName($this -> actors, $actorsId);
			$actorsById[] = $row;
		}
		return $actorsById;
	}
	public function getDirectorById(int $movieId): array
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

		$result = mysqli_query($this -> database, $query);
		if (!$result)
		{
			$error = mysqli_errno($this -> database) . ":" . mysqli_error($this -> database);
			trigger_error($error);
		}
		while ($row = mysqli_fetch_assoc($result))
		{
			$directors[] = $row;
		}
		return $directors;
	}
}