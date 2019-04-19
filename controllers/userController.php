<?php
require("../models/model.php");

function SignIn()	{
	$db = dbConnect();
	require("../views/signInView.php");
}