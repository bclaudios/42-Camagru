<?php require_once("app/views/layouts/header.php");?>
<body>
	<form action="index.php?action=adduser" method="post">
		Login : <br>
		<input type="text" name="login" value="bclaudio" required><br>
		E-Mail : <br>
		<input type="text" name="email" value="bclaudio@gmail.com" required><br>
		E-Mail confirmation : <br>
		<input type="text" name="emailConf" value="bclaudio@gmail.com" required><br>
		Password : <br>
		<input type="password" name="passwd" value="test" required><br>
		Password confirmation : <br>
		<input type="password" name="passwdConf" value="test" required><br>
		<input type="submit" value="Register">
	</form>
</body>