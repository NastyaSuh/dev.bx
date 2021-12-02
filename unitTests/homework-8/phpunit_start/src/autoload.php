<?php

require_once 'Loader.php';

$loader = new \App\Loader;

spl_autoload_register([$loader, 'autoLoad']);