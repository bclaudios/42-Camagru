<?php

if ($argv[1] === "posts")	{
	rmdir("../app/assets/img/posts");
	mkdir('../app/assets/img/posts');
}