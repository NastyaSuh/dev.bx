<?php

namespace App;

class Loader
{
	public function autoLoad(string $className): void
	{
		$prefix = 'App\\';

		$base_dir = __DIR__;

		$len = strlen($prefix);
		if (strncmp($prefix, $className, $len) !== 0)
		{
			return;
		}

		$relative = substr($className, $len);

		$file = $base_dir . '/' . str_replace('\\', '/', $relative) . '.php';

		if (file_exists($file)) {
			require $file;
		}
	}
}