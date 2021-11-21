<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>To do</title>
	<link rel="stylesheet" href=./assets/style.css>
	<link rel="stylesheet" href="./assets/reset.css">
	<!--	подгружаем наш list.js и item.js-->
	<script type="module" src="assets/todo/list.js"></script>
	<script type="module" src="assets/todo/item.js"></script>
</head>
<body>
<h1>To-do</h1>
<div class="calendar-container" data-roles="todo-list"></div>
<script type="module">
	import { List } from './assets/todo/list.js';

	const container = document.querySelector('[data-roles="todo-list"]');
	const list = new List({ container: container });

	list.render();

	console.log(list);
</script>
</body>