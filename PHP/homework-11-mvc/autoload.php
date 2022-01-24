<?php
function autoload(string $className)
{
	if(file_exists('Controllers/'.$className.'.php'))
	{
		require_once 'Controllers/'.$className.'.php';
	}
	elseif(file_exists('Entities/'.$className.'.php'))
	{
		require_once 'Entities/'.$className.'.php';
	}
	elseif(file_exists('Services/'.$className.'.php'))
	{
		require_once 'Services/'.$className.'.php';
	}
	elseif(file_exists('Views/'.$className.'.php'))
	{
		require_once 'Views/'.$className.'.php';
	}
}
spl_autoload_register('autoload');