<?php require_once(__DIR__."/../layouts/header.php"); ?>
	<div class="section">
		<div class="container">
			<?php foreach ($lastsPosts as $post) { ?>
				<!-- CARD -->
				<div class="card">
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
						<div class="media-content" comment_id="<?=$post['post_id']?>">
							<div class="content">
								<p>
									<strong>Login</strong>
									<small>02/10/2019 14:05</small>
									<br>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas Nullam condimentum luctus turpis.
								</p>
							</div>
							<div class="content">
								<p>
									<strong>Login</strong>
									<small>02/10/2019 14:05</small>
									<br>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas Nullam condimentum luctus turpis.
								</p>
							</div>
						</div>
					</article>
					<!-- CARD ADD COMMENT -->
					<div class="comment-input media">
						<div class="media-content">
							<form action="">
							<div class="field">
								<div class="control">
									<input type="text" class="input" placeholder="Add commentary" input_id="<?=$post['post_id']?>">
								</div>
							</div>
						</div>
						<div class="media-right">
							<button type="submit" class="button comment_btn" btn_id="<?=$post['post_id']?>">Post</button>
						</div>
					</form>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
<script src="app/assets/js/comment.js"></script>