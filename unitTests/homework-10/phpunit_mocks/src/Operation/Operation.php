<?php

namespace App\Operation;

use App\Order;
use App\Result;

class Operation
{
	public const EXCEPTION_CODE_WRONG_ACTION_TYPE = 201;

	public const ACTION_BEFORE_SAVE = 'beforeSave';
	public const ACTION_AFTER_SAVE = 'afterSave';

	protected $order;
	protected $actions = [];
	protected $settings;

	public function __construct(Order $order, Settings $settings = null)
	{
		$this->order = $order;
		if (!$settings)
		{
			$settings = $this->getDefaultSettings();
		}
		$this->settings = $settings;
	}

	protected function getDefaultSettings(): Settings
	{
		return (new Settings());
	}

	public function getOrder(): Order
	{
		return $this->order;
	}

	protected function save(): Result
	{
		return $this->order->save();
	}

	public function launch(): Result
	{
		$result = new Result();

//перед действием
		if ($this->settings->isBeforeActionsEnabled())
		{
			$beforeActionsResult = $this->processActions(static::ACTION_BEFORE_SAVE);
			if (!$beforeActionsResult->isSuccess())
			{
				return $result->addErrors($beforeActionsResult->getErrors());
			}
		}

//само действие
		$saveResult = $this->save();
		if (!$saveResult->isSuccess())
		{
			return $result->addErrors($saveResult->getErrors());
		}

//после действия
		if($this -> settings -> isAfterActionsEnabled()){
			$afterActionsResult = $this->processActions(static::ACTION_AFTER_SAVE);
			if (!$afterActionsResult->isSuccess())
			{
				return $result->addErrors($afterActionsResult->getErrors());
			}
		}
		return new Result();
	}

	public function addAction(string $actionPlacement, Action $action): self
	{
		if (
			$actionPlacement !== static::ACTION_BEFORE_SAVE
			&& $actionPlacement !== static::ACTION_AFTER_SAVE
		)
		{
			throw new \Exception('actionPlacement is of a wrong type', static::EXCEPTION_CODE_WRONG_ACTION_TYPE);
		}

		$this->actions[$actionPlacement][] = $action;

		return $this;
	}

	protected function processActions(string $placementCode): Result
	{
		if (!empty($this->actions[$placementCode]))
		{
			/** @var Action $action */
			foreach($this->actions[$placementCode] as $action)
			{
				$actionResult = $action->process($this->order);
				if (!$actionResult->isSuccess())
				{
					return $actionResult;
				}
			}
		}

		return new Result();
	}
}