<?php
/** @var array $movies */
require "movies.php";

echo "Hi! Enter your age: " . "\n";
$userAge = readline("Age: ");

if(is_numeric($userAge))
{
	findMovie((int) $userAge, $movies);
}
else
{
	echo "Invalid form! Please enter correct age";
}
