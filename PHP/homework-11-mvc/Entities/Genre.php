<?php

class Genre
{
	private int $id;
	private string $name;
	private string $code;

	public function __construct(array $data)
	{
		$this->id = $data['ID'];
		$this->name = $data['NAME'];
		$this->code = $data['CODE'];
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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed|string
	 */
	public function getCode()
	{
		return $this->code;
	}
}