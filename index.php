<?php
require("controllers/controller.php");
if (isset($_GET['page']))	{
	$page = $_GET['page'];
	if ($page === "signup")	{
		SignUp();
	}
	if ($page === "register")	{
		CreateUser();
	}
	// DEV ROUTE //
	if ($page === "flushusers")	{
		DelUsersTable();
	}
} else {
	Home();
}