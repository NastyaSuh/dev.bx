<?php

class AddMovieController
{

	private array $genres;
	// private Genre $genre;
	private string $request;
	private string $currentMenuItem;
	private string $plugText;

	public function __construct()
	{
		$config = new Config();
		$database = new MoviesFromDatabase($config->getDatabaseConnectionItem());
		$this->currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('main');
		$this->request = $_GET['request'] ?? "";
		$this->genres = $database->getGenres();

		$this->plugText = $config->getDefaultTitle('add');
		// $this->genre = array_key_exists($this->currentMenuItem, $this->genres) ? $this->genres[$this->currentMenuItem] : '';
	}

	public function getPlugText(): string
	{
		return $this->plugText;
	}

	public function renderAddMovie()
	{
		$content = RenderTemplate::renderTemplate("../Views/pages/add_movie_page.php", [
			'addMovieController'=>$this
		]);

		RenderTemplate::renderTemplate("../Views/pages/start_page.php", [
			'genres'=>$this->genres,
			'request'=>$this->request,
			'currentMenuItem'=>$this->currentMenuItem,
			'content'=> $content
		]);
	}
}