<?php

class Actor
{
	private int $id;
	private string $name;

	public function __construct(array $data)
	{
		$this->id = $data['ID'];
		$this->name = $data['NAME'];
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
}