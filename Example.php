<?php
include_once('UrlFriendly.php');

$url = new UrlFriendly();
$dominio = 'http://tudominio.com/blog/ti/';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Ejemplo de nombres para URLs amigables</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php 
		$post_title = 'La próxima "actualización" de Chrome reducirá hasta en 50% la utilización de RAM.';
		echo "Texto original: ".$post_title."<br>";

		echo "<br>*URL Son Sopt Words <br>";
		$url->setTextoUrl($post_title);

		echo $dominio.$url->getUrlFriendly()."<br>";

		echo "<br>*URL Sin Sopt Words <br>";
		$url->setEliminaStopWords(true);
		echo $dominio.$url->getUrlFriendly();
	?>
</body>
</html>