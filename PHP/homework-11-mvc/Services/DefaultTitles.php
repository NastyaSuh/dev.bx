<?php

class DefaultTitles
{
	private string $favorite_movie_plug_text;
	private string $add_movie_plug_text;
	private string $not_found_movie_plug_text;

	/**
	 * @param string $favorite_movie_stub
	 * @param string $add_movie_stub
	 * @param string $not_found_movie_stub
	 */
	public function __construct(string $favorite_movie_stub, string $add_movie_stub, string $not_found_movie_stub)
	{
		$this->favorite_movie_plug_text = $favorite_movie_stub;
		$this->add_movie_plug_text = $add_movie_stub;
		$this->not_found_movie_plug_text = $not_found_movie_stub;
	}

	public function getFavoriteMoviePlugText(): string
	{
		return $this->favorite_movie_plug_text;
	}

	public function getAddMoviePlugText(): string
	{
		return $this->add_movie_plug_text;
	}

	public function getNotFoundMoviePlugText(): string
	{
		return $this->not_found_movie_plug_text;
	}
}