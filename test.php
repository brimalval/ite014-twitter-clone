<?php
	function echoSomething(){
		echo "<h1>Echo</h1>";
	}

	function returnSomething(){
		return "<h1>Return</h1>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php echoSomething() ?>
	<?= returnSomething() ?>
</body>
</html>