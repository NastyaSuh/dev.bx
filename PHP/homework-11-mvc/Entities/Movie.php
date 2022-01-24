<?php

class Movie
{
	private int $id;
	private string $title;
	private string $originalTitle;
	private string $description;
	private int $releaseDate;
	private int $ageRestriction;
	private float $rating;
	private string $director;
	private Genre $genre;
	private Actor $actor;

	public function __construct(array $data)
	{
		$this->id = $data['ID'];
		$this->title = $data['TITLE'];
		$this->originalTitle = $data['ORIGINAL-TITLE'];
		$this->description = $data['DESCRIPTION'];
		$this->releaseDate = $data['RELEASE-DATE'];
		$this->ageRestriction = $data['AGE-RESTRICTION'];
		$this->rating = $data['RATING'];
		$this->director = $data['DIRECTOR'];
		$this->genre = $data['GENRE'];
		$this->actor = $data['ACTOR'];
	}

	/**
	 * @return int|mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed|string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return mixed|string
	 */
	public function getOriginalTitle()
	{
		return $this->originalTitle;
	}

	/**
	 * @return mixed|string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return int|mixed
	 */
	public function getReleaseDate()
	{
		return $this->releaseDate;
	}

	/**
	 * @return int|mixed
	 */
	public function getAgeRestriction()
	{
		return $this->ageRestriction;
	}

	/**
	 * @return float|mixed
	 */
	public function getRating()
	{
		return $this->rating;
	}

	/**
	 * @return mixed|string
	 */
	public function getDirector()
	{
		return $this->director;
	}

	/**
	 * @return Genre|mixed
	 */
	public function getGenre()
	{
		return $this->genre;
	}

	/**
	 * @return Actor|mixed
	 */
	public function getActor()
	{
		return $this->actor;
	}
}