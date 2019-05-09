<?php require_once("app/views/layouts/header.php");?>
<body>
	<form>
		Login : <br>
		<input type="text" id="signup_login" required><br>
		E-Mail : <br>
		<input type="text" id="signup_email" required><br>
		E-Mail confirmation : <br>
		<input type="text" id="signup_emailConf" required><br>
		Password : <br>
		<input type="password" id="signup_passwd" required><br>
		Password confirmation : <br>
		<input type="password" id="signup_passwdConf" required><br>
		<button type="submit" id="signup_btn">Register</button>
	</form>
	<script type="text/javascript" src="/app/assets/js/signup.js"></script>
</body>