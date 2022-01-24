<?php
function renderTemplate(string $path, array $templateData = []): string
{
	if (!file_exists($path))
	{
		return "no file";
	}

	extract($templateData, EXTR_OVERWRITE);

	ob_start();

	include $path;

	return ob_get_clean();
}
