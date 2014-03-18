<?php
	session_start();
?>

<html>
<head>
	<title>Welcome</title>
	<style type='text/css'>
		body{
			text-align: center;
		}
		#container{
			display: inline-block;
			text-align: right;
		}
		label{
			display: block;
		}
		span{
			color: red;
		}
	</style>
</head>
<body>
	<div id='container'>
		<h1>Expenses Tracker</h1>
<?php
	if(isset($_SESSION['errors']))
	{
		foreach($_SESSION['errors'] as $error)
		{
			echo "<p><span>" . $error . "</span></p>";
		}
	session_destroy();
	}
?>
		<form action='process.php' method='post'>
			<input type='hidden' name='action' value='register'>
			<label>
				Your Name:
				<input type='text' name='name'>
			</label>
			<label>
				Your Starting Budget ($):
				<input type='text' name='budget'>
			</label>
			<input type='submit'>
		</form>
	</div>
</body>
</html>