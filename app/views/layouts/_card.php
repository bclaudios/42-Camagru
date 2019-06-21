<?php
$comLimit = !isset($title) || $title == "Gallery" ? 3 : 999;
?>
<!-- CARD -->
<div class="card post-card" id="<?= $post['post_id']?>">

	<!-- CARD HEADER -->
	<div class="card-header">
		<div class="card-header-title">
			<div class="media">
				<div class="media-left">
					<figure class="image">
						<a href="index.php?page=profil&login=<?=$post['login']?>"><img src="app/assets/img/profil/<?=$post['user']['profilPic']?>" class="profil-pic is-rounded"></a>
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
			<img src="app/assets/img/posts/<?=$post['path']?>" class="card-image" alt="">
		</figure>
	</div>

	<div class="container infos-container">
	<!-- CARD LIKES AND STUFF -->
		<nav class="card-infos level is-mobile">
			<div class="level-left">
	    		<a class=" level-item">
	      			<span class="icon is-small">
					<?php if (isset($_SESSION['user']) && $post['liked']) {?>
						<img class="unlike-btn" src="app/assets/img/icon/heart-filled.svg"></span>
					<?php } elseif (isset($_SESSION['user']) && !$post['liked']) { ?>
						<img class="like-btn" src="app/assets/img/icon/heart-empty.svg"></span>
					<?php } else { ?>
						<img src="app/assets/img/icon/heart-empty.png"></span>
					<?php } ?>
				</a>
				<div class="level-item">
	    			<p class="like-count"><?=$post['likesCount']?></p>
				</div>
			</div>
			<?php if (isset($_SESSION['user']) && $post['login'] === $_SESSION['user']) { ?>
			<div class="level-right">
				<div class="level-item">
					<span class="icon is-small">
						<img src="app/assets/img/icon/garbage.svg" class="delete-btn">						
					</span>
				</div>
			</div>
			<?php } ?>
		</nav>

		<!-- CARD LAST COMMENT -->
		<article class="media">
			<div class="comment_list media-content">
				<?php 
				for ($i = 0; $i < $comLimit; $i++) {
					if ($i >= sizeof($post['comments']))
						break;
					$comment = $post['comments'][$i]; 
					require(__DIR__."/_comment.php"); 
				}
				?>
			</div>
		</article>
		<!-- SHOW ALL COMMENTS BUTTON -->
		<div>
		<?php if ($comLimit == 3 && isset($post['comments'][3])) { ?>
			<button class="button show_comments"><a href="index.php?page=post&post_id=<?=$post['post_id']?>">Show all comments</a></button>
		<?php } ?>
		</div>

		<!-- CARD ADD COMMENT -->
		<?php if (isset($_SESSION['user'])) { ?>
		<form>
			<div class="comment-input media">
				<div class="media-content">
					<div class="field">
						<div class="control">
							<input type="text" class="input" placeholder="Add a comment ...">
						</div>
					</div>
				</div>
				<div class="media-right">
					<button type="submit" class="button comment_btn">Post</button>
				</div>
			</div>
		</form>
		<?php } ?>
	</div>
</div>