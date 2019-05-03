<?php require_once("app/views/layouts/header.php");?>
<body>
	<form>
		Login : <br>
		<input type="text" id="signup_login" value="bclaudio" required><br>
		E-Mail : <br>
		<input type="text" id="signup_email" value="bclaudio@gmail.com" required><br>
		E-Mail confirmation : <br>
		<input type="text" id="signup_emailConf" value="bclaudio@gmail.com" required><br>
		Password : <br>
		<input type="password" id="signup_passwd" value="test" required><br>
		Password confirmation : <br>
		<input type="password" id="signup_passwdConf" value="test" required><br>
		<button type="submit" id="signup_btn">Register</button>
	</form>
	<script type="text/javascript" src="/app/assets/js/signup.js"></script>
</body>