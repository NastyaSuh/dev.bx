<?php

class FavoriteMovieController
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
		$this->currentMenuItem = $_GET['menuItem'] ?? $config->getMenuItem('favorites');
		$this->request = $_GET['request'] ?? "";
		$this->genres = $database->getGenres();
		$this->plugText = $config->getDefaultTitle('favorites');
		// $this->genre = array_key_exists($this->currentMenuItem, $this->genres) ? $this->genres[$this->currentMenuItem] : '';
	}

	public function getPlugText(): string
	{
		return $this->plugText;
	}

	public function renderFavoriteMovie()
	{
		$content = RenderTemplate::renderTemplate("../Views/pages/favorite_movie_page.php", [
			'favoriteMovieController'=>$this
		]);
		RenderTemplate::renderTemplate("../Views/pages/start_page.php", [
			'genres'=>$this->genres,
			'request'=>$this->request,
			'currentMenuItem'=>$this->currentMenuItem,
			'content'=> $content
		]);
	}
}