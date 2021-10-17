<?php
require "movies.php";

echo "Hi! Enter your age: " . "\n";
$userAge = readline("Age: ");

if($userAge >= 0)
	findMovie($userAge, $movies);
else
	echo "Please enter correct age";

function findMovie(int $userAge, array $movies): void{
	$i = 1;
	foreach ($movies as $film){
		if($film['age_restriction'] <= $userAge){
			echo "{$i}. {$film['title']} ({$film['release_year']}), {$film['age_restriction']}+. Rating: {$film['rating']};" . "\n";
			$i ++;
		}
	}
}