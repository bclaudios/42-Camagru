<?php
require_once __DIR__.'/../models/postModel.php';
// session_start();

##### CONTROLLER #####
if (isset($_POST['action']))	{
	$action = $_POST['action'];
	if ($action === "createPost")
		CreatePost();
}

function view_Montage()	{
	$title = "New Post";
	require_once("app/views/pages/montage.php");
}

function CreatePost()	{
	
}