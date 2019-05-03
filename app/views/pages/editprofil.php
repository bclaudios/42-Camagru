<?php 
require_once("app/views/layouts/header.php");
?>
<body>
    <h2>Edit personnal informations</h2>
    
	<h3>Change username</h3>
	<form>
		New username :
        <input type="text" id="edit_newLogin" placeholder="<?=$user['login']?>"><br>
		<button type="submit" id="editLogin_btn">Change username</button><br>
	</form>
	<h3>Change e-mail address</h3><br>
    <form>
        New e-mail :
        <input type="text" id="edit_newEmail" placeholder="<?=$user['email']?>"><br>
		New e-mail confirmation :
		<input type="text" id="edit_newEmailConf"><br>
        <button type="submit" id="editEmail_btn">Change e-mail address</button><br>
    </form>

    <form>
        Current Password :
        <input type="password" id="edit_currentPasswd" required><br>
        New Password :
        <input type="password" id="edit_newPasswd" required><br>
		New Password confirmation :
		<input type="password" id="edit_newPasswdConf" required><br>
		<button type="submit" id="editPasswd_btn">Apply</button>
    </form>
</body>