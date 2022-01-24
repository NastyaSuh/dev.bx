<?php

class DetailedMovieController
{
	// private array $movies;
	private array $genres;
	// private array $actors;
	private int $movieId;
	private string $currentMenuItem;
	private string $request;
	// private Genre $genre;
	private Actor $actor; //private Actor $actor
	private Movie $movie; //private Movie $movie
	private string $director;
	private string $plugText;

	public function __construct()
	{
		$config = new Config();
		$database = new MoviesFromDatabase($config->getDatabaseConnectionItem());

		$this->currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('main');
		$this->request = $_GET['request'] ?? "";

		$this->movieId = (int)$_GET['movieId'];

		$this->genres = $database->getGenres();
		// $this->actors = $database->getActors();

		// $this->genre = array_key_exists($this->currentMenuItem, $this->genres) ? $this->genres[$this->currentMenuItem : '';
		// $this->movies = $database->getMoviesByQuery($this->request, $this->genre);

		$this->movie = $database->getMovieById($this->movieId)[0];
		$this->actor = $database->getActorsById($this->movieId)[0];
		$this->director = $database->getDirectorById($this->movieId)[0];

		$this->plugText = $config->getDefaultTitle('not_found');
	}

	public function getPlugText(): string
	{
		return $this->plugText;
	}

	public function getMovies(): array
	{
		return $this->movie;
	}

	public function renderDetailedMovie()
	{
		if(isset($this->movieId))
		{
			if(!$this->movie)
			{
				$content = RenderTemplate::renderTemplate("../Views/pages/movie_not_found.php", [
					'movieNotFound'=>$this
				]);
			}
			else
			{
				$content = RenderTemplate::renderTemplate("../Views/pages/detailed_movie.php", [
					'movie'=>$this->movie,
					'actor'=>$this->actor,
					'director'=>$this->director
				]);
			}
		}
		RenderTemplate::renderTemplate("../Views/pages/start_page.php", [
			'genres'=>$this->genres,
			'request'=>$this->request,
			'currentMenuItem'=>$this->currentMenuItem,
			'content'=>$content
		]);
	}
}