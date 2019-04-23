<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<form action="index.php?page=register" method="post">
	Login
	<input type="text" name="login" value="test" required><br>
	E-mail
	<input type="text" name="email" value="test@test.com" required><br>
	E-mail confirmation
	<input type="text" name="emailconf" value="test@test.com" required><br>
	Password
	<input type="password" name="passwd" value="Test1234" required><br>
	Password confirmation
	<input type="password" name="passwdconf" value="Test1234" required><br>
	<input type="submit" value="Sign up"><br>
	</form>
</body>
</html>