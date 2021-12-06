<?php

namespace App\Operation;

use App\Order;
use App\Result;

abstract class Action
{
	abstract public function process(Order $order): Result;
}