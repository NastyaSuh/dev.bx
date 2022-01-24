<?php

class Config
{
	private array $menu;
	private array $default_titles;
	private static array $search_items;
	private DatabaseConnectionSettings $database_connection_items;

	public function __construct()
	{
		$this -> menu = [
			'main' => 'Главное',
			'favorites'=>'Избранное'
		];
		$this -> default_titles = [
			'favorites'=>'Вы попали на страницу с избранными фильмами. Она пока находится в разработке :)',
			'add'=>'Вы попали на страницу с добавлением новых фильмов. Она пока находится в разработке :)',
			'not_found'=>'К сожалению, по вашему запросу ничего не найдено.'
		];
		self::$search_items = [
			'title', '`original-title`', 'genres', 'director'
		];
		$this -> database_connection_items = new DatabaseConnectionSettings(
			'localhost', 'student', 'student', 'dev');
	}

	public function getMenuItem(string $name): string
	{
		return $this -> menu[$name];
	}

	public function getDefaultTitle(string $name): string
	{
		return $this -> default_titles[$name];
	}

	public static function getSearchItem(): array
	{
		return self::$search_items;
	}

	public function getDatabaseConnectionItem(): DatabaseConnectionSettings
	{
		return $this -> database_connection_items;
	}
}