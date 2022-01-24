<?php

class MovieListController
{
	private array $movies;
	private array $genres;
	private string $currentMenuItem;
	private string $request;
	private string $plugText;
	private ?Genre $genre;

	public function __construct()
	{
		$config = new Config();
		$database = new MoviesFromDatabase($config->getDatabaseConnectionItem());
		//$config = Config::getInstance();
		//$database = MovieDatabase::getInstance($config->getDatabaseConnectionSettings());
		$this->currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('main');
		$this->request = $_GET['request'] ?? "";

		$this->genres = $database->getGenres();
		$this->genre = array_object_key_exists($this->genres, $this->currentMenuItem) ? $this->genres[$this->currentMenuItem] : null;
		$this->movies = $database->getMoviesByQuery($this->request, $this->genre->getCode());

		$this->plugText = $config->getDefaultTitle('not_found');
	}

	public function getPlugText(): string
	{
		return $this->plugText;
	}

	public function renderMovieList()
	{
		if(empty($this->movies))
		{
			$content = RenderTemplate::renderTemplate("../Views/pages/not_found.php", [
				'movieNotFound'=>$this
			]);
		}
		else
		{
			$content = RenderTemplate::renderTemplate("../Views/pages/movie_card.php", [
				'movies'=>$this->movies
			]);
		}
		RenderTemplate::renderTemplate("../Views/pages/start_page.php", [
			'genres'=>$this->genres,
			'request'=>$this->request,
			'currentMenuItem'=>$this->currentMenuItem,
			'content'=> $content
		]);
	}
}