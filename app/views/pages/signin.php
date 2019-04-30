<?php require_once("app/views/layouts/header.php"); ?>
<body>
    <form action="index.php?action=loguser" method="post">
        Login : <br>
        <input type="text" name="login"><br>
        Password :
        <input type="password" name="passwd"><br>
        <input type="submit" value="login"><br>
    </form>
</body>
</html>