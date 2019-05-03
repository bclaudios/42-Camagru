<?php 
require_once("app/views/layouts/header.php");
?>
<body>
    <h2>Change password</h2>
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