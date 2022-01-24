<?php

class RenderTemplate
{
	public static function renderTemplate(string $path, array $templateData = [])
	{
		ob_start();

		require_once $path;

		$view = ob_get_clean();

		echo $view;
	}
}