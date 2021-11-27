<?php
/** @var array $movies */
?>

<div class="movie-list">
	<?php
	foreach ($movies as $movie): ?>
		<div class="movie-list-item">
			<div class="movie-list-item-overlay">
				<div class="movie-overlay">
<!--					<a href="index.php?id=--><?//= $movie['id'] ?><!--" class="more-button">Подробнее</a>-->
					<a href="index_detailed_movie.php?movieId=<?= $movie['id'] ?>" class="more-button">Подробнее</a>
				</div>
			</div>
			<div class="movie-list-item-image" style="background:
				url('images/<?= $movie['id'] ?>.jpg') center no-repeat;
				background-size: cover">
			</div>
			<div class="movie-list-item-head">
				<div class="head-title"><?= formatTitle($movie['title']) ?></div>
				<div class="head-subtitle"><?= $movie['original-title'] ?></div>
				<div class="head-wrapper"></div>
			</div>
			<div class="movie-list-item-description"><?= formatDescription($movie['description']) ?></div>
			<div class="movie-list-item-footer">
				<div class="footer-duration">
					<?= formatDuration($movie['duration']) ?>
					<div class="footer-clock"></div>
				</div>
				<div class="footer-info">
					<?= $movie['genres'] ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
