<?php 
require_once("elements/header.php"); 
$userInfos = $_SESSION['logguedUser'];
?>
<body>
    <h2>Edit personnal informations</h2>
    
    <form action="index.php?action=editprofil" method="post">
        New Login :
        <input type="text" name="newLogin" value="<?=$userInfos['login']?>"><br>
        New E-mail :
        <input type="text" name="newEmail" value="<?=$userInfos['email']?>"><br>
        <input type="submit" value="Apply Changes"><br>
    </form>

    <form action="index.php?action=editpasswd" method="post">
        Current Password :
        <input type="password" name="currentPasswd" required><br>
        New Password :
        <input type="password" name="newPasswd" required><br>
        <input type="submit" value="Apply Changes">
    </form>

</body>