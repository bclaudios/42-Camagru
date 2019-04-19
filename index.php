<?php
echo "testetet";
require("controllers/userController.php");
if ($_GET['page'])	{

} else	{
	SignIn();
}