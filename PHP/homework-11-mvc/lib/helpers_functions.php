<?php
function formatDescription(string $description): string
{
	return mb_strimwidth($description, 0, 150, "...");
}

function formatTitle(string $title): string
{
	return mb_strimwidth($title, 0, 25, "...");
}

function formatDuration(int $duration): string
{
	$hours = (int)($duration / 60);
	$minutes = $duration - $hours * 60;

	$h = str_pad((string)$hours, 2, "0", STR_PAD_LEFT);
	$m = str_pad((string)$minutes, 2, "0", STR_PAD_LEFT);

	return "$duration мин./ $h.$m";
}

function formatRating(float $rating): string
{
	return str_pad((string)$rating, 3, ".0", STR_PAD_RIGHT);
}

function arrayToString(array $array): string
{
	return implode(', ', $array);
}

function convertArrayFromIdsToName($arrays, $arrayId): array
{
	$namesArray = [];
	foreach($arrayId as $id)
	{
		$namesArray[] = $arrays[$id];
	}
	return $namesArray;
}

function array_object_key_exists(array $array, string $key): bool
{
	$object = find_element_by_name($array, $key);
	if(!isset($object))
	{
		return false;
	}
	return true;
}

function find_element_by_name(array $array, string $key): ?Genre
{
	foreach ($array as $item)
	{
		if($item->getName() == $key)
		{
			return $item;
		}
	}
	return null;
}