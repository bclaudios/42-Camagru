<?php 
require_once(__DIR__."/../layouts/header.php"); 
?>
	<div class="section">
		<div class="container">
			<?php foreach ($lastsPosts as $post) {
				require("app/views/layouts/cardGallery.php");
			} ?>
			</div>
		</div>
	</div>
</body>
<script src="app/assets/js/comment.js"></script>
<script src="app/assets/js/like.js"></script>