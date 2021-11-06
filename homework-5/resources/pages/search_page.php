<?php
/** @var array $request */
?>
<div class="searchbar">
	<div class="search">
		<form action="index.php" method="post" enctype="multipart/form-data" class="search-form">
			<div class="search-line">
				<div class="search-icon"></div>
				<input type="text" id="request" name="request" class="search-field" placeholder="Поиск по каталогу..."
					   value="<?= $request ?>">
			</div>
			<input type="submit" value="Искать" class="search-btn">
		</form>
	</div>
	<a href="index.php?addMovie=true" class="movie-add-btn">Добавить фильм</a>
</div>
