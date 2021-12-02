<?php

namespace App;

class Result
{
	protected $isSuccess = true;

	protected $errors;

	protected $data = [];

	public function __construct()
	{
		$this->errors = [];
	}

	/**
	 * Returns the result status.
	 *
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->isSuccess;
	}

	/**
	 * Adds the error.
	 *
	 * @param \Error $error
	 * @return $this
	 */
	public function addError(\Error $error)
	{
		$this->isSuccess = false;
		$this->errors[] = $error;
		return $this;
	}

	/**
	 * Returns an array of Error objects.
	 *
	 * @return \Error[]
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Returns array of strings with error messages
	 *
	 * @return array
	 */
	public function getErrorMessages()
	{
		$messages = [];

		foreach($this->getErrors() as $error)
		{
			$messages[] = $error->getMessage();
		}

		return $messages;
	}

	/**
	 * Adds array of Error objects
	 *
	 * @param \Error[] $errors
	 * @return $this
	 */
	public function addErrors(array $errors)
	{
		$this->isSuccess = false;
		$this->errors += $errors;

		return $this;
	}

	/**
	 * Sets data of the result.
	 * @param array $data
	 * @return $this
	 */
	public function setData(array $data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * Returns data array saved into the result.
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}
}
