<?php 
require_once(__DIR__."/../layouts/header.php"); 
if (isset($_SESSION['user'])) {
	$canComment = "";
	$inputPlaceHolder = "Add commentary...";
} else {
	$canComment = "disabled";
	$inputPlaceHolder = "You must be logged in to add commentary.";
}?>
	<main class="section">
		<?php require_once("app/views/layouts/cardPost.php");?>
	</main>
</body>
<script src="app/assets/js/comment.js"></script>
<script src="app/assets/js/like.js"></script>