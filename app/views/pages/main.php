<?php
require_once("app/views/layouts/header.php");
?>
<body>
<?php 
	if (isset($_SESSION['user']))
		echo $_SESSION['user'];?>
</body>