<?php
require_once("controllers/userController.php");

if (isset($_GET['page']) || isset($_GET['action']))	{
	$page = $_GET['page'];
	$action = $_GET['action'];
	if ($page === "signup")	{
		view_SignUp();
	}
	if ($action === "adduser")	{
		
	}
} else {
	view_Home();
}