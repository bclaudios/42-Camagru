<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
$comCount = 3;
?>
	<div class="section">
		<div class="container">
			<?php foreach ($lastsPosts as $post) {
				require("app/views/layouts/_card.php");
			} ?>
			</div>
		</div>
	</div>
</body>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script src="app/assets/js/comment.js"></script>
<script src="app/assets/js/like.js"></script>
<script src="app/assets/js/deletePost.js"></script>