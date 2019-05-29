<?php if (isset($_SESSION['user'])) {
	$canComment = "";
	$inputPlaceHolder = "Add commentary...";
} else {
	$canComment = "disabled";
	$inputPlaceHolder = "You must be logged in to add commentary.";
} ?>
<!-- CARD -->
<div class="card gallery-card" id="<?= $post['post_id']?>">

	<!-- CARD HEADER -->
	<div class="card-header">
		<div class="card-header-title">
			<div class="media">
				<div class="media-left">
					<figure class="image">
						<img src="app/assets/img/icon/profil-placeholder.png" class="profil-pic is-rounded">
					</figure>
				</div>
				<div class="media-content post-user-infos">
					<a href="index.php?page=profil&login=<?=$post['login']?>" class="card-login"><?=$post['login']?></a>
					<p class="card-date"><?=$post['date']?> <?=$post['time']?></p>
				</div>
			</div>
		</div>
	</div>

	<!-- CARD IMAGE -->
	<div class="card-image-container">
		<figure class="image is-16by10">
			<img src="app/assets/img/posts/<?=$post['path']?>" class="card-image">
		</figure>
	</div>

	<div class="container infos-container">
	<!-- CARD LIKES AND STUFF -->
		<nav class="card-infos level is-mobile">
			<div class="level-left">
	    		<a class="level-item">
	      			<span class="icon is-small">
					<?php if ($post['liked']) {?>
						<img class="unlike-btn" src="app/assets/img/icon/heart-filled.png"></span>
					<?php } else { ?>
						<img class="like-btn" src="app/assets/img/icon/heart-empty.png"></span>
					<?php } ?>
				</a>
				<div class="level-item">
	    			<p class="like-count"><?=$post['likesCount']?></p>
				</div>
			</div>
		</nav>

		<!-- CARD ALL COMMENT -->
		<article class="media">
			<div class="comment_list media-content">
				<?php foreach ($post['comments'] as $comment) {
				$comment = $post['comments'][0]; ?> 
					<div class="comment content">
						<p>
						<a href="index.php?page=profil&login=<?=$comment['login']?>"><strong><?= $comment['login'] ?></strong></a>
							<small><i><?= $comment['date'] . " " . $comment['time'] ?></i></small>
							<br>
							<?= $comment['comment'] ?>
						</p>
					</div>
				<?php } ?>
			</div>
		</article>
		<!-- CARD ADD COMMENT -->
		<form>
			<div class="comment-input media">
				<div class="media-content">
					<div class="field">
						<div class="control">
							<input type="text" class="input" placeholder="<?=$inputPlaceHolder?>" <?=$canComment?>>
						</div>
					</div>
				</div>
				<div class="media-right">
					<button type="submit" class="button comment_btn" <?=$canComment?>>Post</button>
				</div>
			</div>
		</form>
	</div>
</div>