<?php
/** @var Movie $movie */
/** @var string $director */
/** @var Actor $actor */

?>
<div class="detailed-movie-item">
	<div class="detailed-movie-item-head">
		<div class="item-head-title">
			<?= $movie->getTitle() . " (" . $movie->getReleaseDate() . ")" ?>
			<div class="head-favorites"></div>
		</div>
		<div class="item-head-subtitle">
			<div class="head-subtitle-title"><?= $movie->getOriginalTitle() ?></div>
			<div class="head-subtitle-age-restriction">
				<div class="age-restriction">
					<?= $movie->getAgeRestriction() . "+" ?>
				</div>
			</div>
		</div>
	</div>
	<div class="detailed-movie-item-wrapper"></div>
	<div class="detailed-movie-item-body">
		<div class="detailed-movie-item-body-poster"
			 style="background: url('images/<?= $movie->getId() ?>.jpg') center no-repeat;
				 background-size: cover">
		</div>
		<div class="detailed-movie-item-body-info">
			<div class="info-rating">
				<?php
				for ($i = 1; $i <= 10; $i++): ?>
					<div class="info-rating-rectangle-active <?= $i > round($movie->getRating()) ? 'info-rating-rectangle' : '' ?>"></div>
				<?php endfor; ?>
				<div class="info-rating-circle">
					<div class="circle-number">
						<?= formatRating($movie->getRating()) ?>
					</div>
				</div>
			</div>
			<h1 class="info-about-film">О фильме</h1>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">Год производства:</div>
				<div class="info-about-film-more-text"><?= $movie->getReleaseDate() ?></div>
			</div>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">Режиссер:</div>
				<div class="info-about-film-more-text"><?= $director ?></div>
			</div>
			<div class="info-about-film-more">
				<div class="info-about-film-more-name">В главных ролях:</div>
				<div class="info-about-film-more-text"><?= $actor->getName() ?></div>
			</div>
			<h1 class="info-about-film">Описание</h1>
			<div class="info-about-film-description">
				<?= $movie->getDescription() ?>
			</div>
		</div>
	</div>
</div>

