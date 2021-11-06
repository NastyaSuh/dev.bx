<?php
/** @var array $request */
?>
<div class="searchbar">
	<div class="search">
		<form action="index.php" method="post" enctype="multipart/form-data" class="search-form">
		<div class="search-line">
			<div class="search-icon"></div>
<!--			<div class="search-field">Поиск по каталогу...</div>-->
			<input type="text" id="request" name="request" class="search-field" placeholder="Поиск по каталогу..."
			value="<?= $request ?>">
		</div>
<!--		<a href="index.php" class="search-btn">Искать</a>-->
		<input type="submit" value="Искать" class="search-btn">
		</form>
	</div>
	<a href="index.php?addMovie=true" class="movie-add-btn">Добавить фильм</a>
</div>

<!--<input type="submit" name="send" value="Отправить">-->
<!--enctype="multipart/form-data"-->