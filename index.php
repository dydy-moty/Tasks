<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Гостевая книга</h1>
			
			
			<?php include 'pagination.php'; ?>
			
			<div class="info alert alert-info <?php if ($isAdded) { echo'activeClass';} else { echo '';}?>" id='myModal'>
				Запись успешно сохранена!
			</div>
			<div id="form">
				<form action="#form" method="POST">
					<p><input name = 'name' class="form-control" placeholder="Ваше имя"></p>
					<p><textarea name = 'comment' class="form-control" placeholder="Ваш отзыв"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить" id='myButton'></p>
				</form>
			</div> 
		</div>
	   <script type="text/javascript" src="JavaScript.js"></script>
	</body>
</html>
