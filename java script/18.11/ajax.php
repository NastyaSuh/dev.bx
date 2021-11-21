<?php

header('content-type: application/json; charset=UTF-8');

const FILE_NAME = "data.json";

$action = $_GET['action'] ?? null;
$result = [];

$returnResult = function(array $result): void {
	echo json_encode($result);
};

$saveItems = function() {
	$data = file_get_contents('php://input');
	//надо преобразовать строку $data в ассоциативный массив
	try
	{
		$response = json_decode($data, true);
	}
	catch (JsonException $e)
	{
		$response = null;
	}

	if ($response === null)
	{
		return [
			'error' => 'Incorrect json data',
		];
	}

	$items = (array)($response['items'] ?? null);

	file_put_contents(
		FILE_NAME,
		json_encode([
						'items' => $items,
					])
	);

	return [];
};

$loadItems = function() {
	if (!file_exists(FILE_NAME))
	{
		return [
			'items' => [],
		];
	}
	$encodedData = file_get_contents(FILE_NAME);
	try
	{
		$data = json_decode($encodedData, true);
	}
	catch (JsonException $e)
	{
		$data = [];
	}

	return [
		'items' => $data['items'] ?? [],
	];
};

if ($action === 'save')
{
	// sleep(2);
	$result = $saveItems();

	return $returnResult($result);
}

if ($action === 'load')
{
	$result = $loadItems();

	return $returnResult($result);
}

$returnResult(['error' => 'unknown action']);