<?php

namespace App\Operation;

class Settings
{
	protected bool $isBeforeActionsEnabled = true;
	protected bool $isAfterActionsEnabled = true;

	public function disableBeforeSaveActions(): self
	{
		$this->isBeforeActionsEnabled = false;

		return $this;
	}

	public function disableAfterSaveActions(): self
	{
		$this->isAfterActionsEnabled = false;

		return $this;
	}

	public function isBeforeActionsEnabled(): bool
	{
		return $this->isBeforeActionsEnabled;
	}

	public function isAfterActionsEnabled(): bool
	{
		return $this->isAfterActionsEnabled;
	}
}