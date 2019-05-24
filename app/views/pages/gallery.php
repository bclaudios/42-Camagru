<?php 
require_once(__DIR__."/../layouts/header.php"); 
if (isset($_SESSION['user'])) {
	$canComment = "";
	$inputPlaceHolder = "Add commentary...";
} else {
	$canComment = "disabled";
	$inputPlaceHolder = "You must be logged in to add commentary.";
}
?>
	<div class="section">
		<div class="container">
			<?php foreach ($lastsPosts as $post) { ?>
				<!-- CARD -->
				<div class="card gallery-card" id="<?= $post['post_id']?>">
					<!-- CARD HEADER -->
					<div class="card-header">
						<div class="card-header-title">
							<div class="media">
								<div class="media-left">
									<figure class="image">
										<img src="http://www.sclance.com/pngs/image-placeholder-png/image_placeholder_png_698733.png" class="profil-pic is-rounded">
									</figure>
								</div>
								<div class="media-content">
									<strong><?=$post['login']?></strong> <br><small><?=$post['date']?> <?=$post['time']?></small>
								</div>
							</div>
						</div>
					</div>
					<!-- CARD IMAGE -->
					<div class="card-image">
						<figure class="image is-16by10">
							<img src="app/assets/img/posts/<?=$post['path']?>" alt="">
						</figure>
					</div>
					<!-- CARD LIKES AND STUFF -->
					<nav class="card-infos level is-mobile">
    					<div class="level-left">
    				    	<a class=" level-item">
    				      		<span class="icon is-small"><img class="like-btn" src="app/assets/img/icon/heart-empty.png"></span>
    				    	</a>
						<div class="level-item">
    				    	<p class="like-count"><?=$post['likesCount']?></p>
    					</div>
    					</div>
    				</nav>
					<!-- CARD COMMENT -->
					<article class="media">
						<div class="comment_list media-content">
						<?php	if (!empty($post['comments'])) {
							$comment = $post['comments'][0]; ?> 
							<div class="comment content">
								<p>
									<strong><?= $comment['login'] ?></strong>
									<small><?= $comment['date'] . " " . $comment['time'] ?></small>
									<br>
									<?= $comment['comment'] ?>
								</p>
							</div>
						<?php } ?>
						</div>
						<br>
					</article>
					<?php if (isset($post['comments'][1])) { ?>
						<button class="button show_comments">Show more</button>
					<?php } ?>
					<!-- CARD ADD COMMENT -->
					<div class="comment-input media">
						<div class="media-content">
							<form>
							<div class="field">
								<div class="control">
									<input type="text" class="input" placeholder="<?=$inputPlaceHolder?>" <?=$canComment?>>
								</div>
							</div>
						</div>
						<div class="media-right">
							<button type="submit" class="button comment_btn" <?=$canComment?>>Post</button>
						</div>
					</form>
					</div>

				</div>
			<?php } ?>
		</div>
	</div>
</body>
<script src="app/assets/js/comment.js"></script>
<script src="app/assets/js/like.js"></script>