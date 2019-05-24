<?php require_once(__DIR__."/../layouts/header.php"); ?>
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
									<figure class="image is-42x42">
										<img src="https://img.icons8.com/ios/50/000000/name-filled.png">
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
					<!-- CARD COMMENT -->
					<article class="media">
						<div class="comment_list media-content">
						<?php	if (!empty($post['comments'])) { // [modif] Try to send the last comment directly in postController
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
					<button class="button show_comments">Show more</button>
					<!-- CARD ADD COMMENT -->
					<div class="comment-input media">
						<div class="media-content">
							<form>
							<div class="field">
								<div class="control">
									<input type="text" class="input" placeholder="Add commentary">
								</div>
							</div>
						</div>
						<div class="media-right">
							<button type="submit" class="button comment_btn">Post</button>
						</div>
					</form>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
<script src="app/assets/js/comment.js"></script>