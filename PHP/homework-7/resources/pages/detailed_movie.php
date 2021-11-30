<?php
/** @var array $movie */
/** @var array $actorsById */
/** @var array $directors */
?>
<div class="detailed-movie-item">
	<div class="detailed-movie-item-head">
		<div class="item-head-title">
			<?= $movie['title'] . " (" . $movie['release-date'] . ")" ?>
			<div class="head-favorites"></div>
		</div>
		<div class="item-head-subtitle">
			<div class="head-subtitle-title"><?= $movie['original-title'] ?></div>
			<div class="head-subtitle-age-restriction">
				<div class="age-restriction">
					<?= $movie['age-restriction'] . "+" ?>
				</div>
			</div>
		</div>
	</div>
	<div class="detailed-movie-item-wrapper"></div>
	<div class="detailed-movie-item-body">
		<div class="detailed-movie-item-body-poster"
			 style="background: url('images/<?= $movie['id'] ?>.jpg') center no-repeat;
				 background-size: cover">
		</div>
		<div class="detailed-movie-item-body-info">
			<div class="info-rating">
				<?php
				for ($i = 1; $i <= 10; $i++): ?>
					<div class="info-rating-rectangle-active <?= $i > round($movie['rating']) ? 'info-rating-rectangle' : '' ?>"></div>
				<?php endfor; ?>
				<div class="info-rating-circle">
					<div class="circle-number">
						<?= formatRating($movie['rating']) ?>
					</div>
				</div>
			</div>
			<h1 class="info-about-film">О фильме</h1>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">Год производства:</div>
				<div class="info-about-film-more-text"><?= $movie['release-date'] ?></div>
			</div>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">Режиссер:</div>
				<div class="info-about-film-more-text"><?= arrayToString($directors) ?></div>
			</div>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">В главных ролях:</div>
				<div class="info-about-film-more-text"><?=arrayToString($actorsById['actors']) ?></div>
			</div>
			<h1 class="info-about-film">Описание</h1>
			<div class="info-about-film-description">
				<?= $movie['description'] ?>
			</div>
		</div>
	</div>
</div>

