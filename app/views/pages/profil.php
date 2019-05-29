<?php require_once(__DIR__."/../layouts/header.php"); ?>
<body>
    <main class="section">
		<div class="container profil-container">
				<div class="card profil-card">
					<div class="card-content">
						<div class="media">
							<!-- PROFIL PIC -->
							<div class="media-left">
								<figure class="image is-96x96 is-rounded">
									<img src="app/assets/img/profil/<?=$user['profilPic']?>" style="border-radius:10000px;" alt="">
								</figure>
							</div>
							<!-- USER INFOS -->
							<div class="media-content">
								<h2 class="title"><?=$user['login']?></h2>
							</div>
							<?php if ($_SESSION['user'] === $user['login']) {?>
								<div class="media-right">
									<span class="icon is-large">
										<a href="index.php?page=editProfil"><img src="app/assets/img/icon/settings.png" class="image" alt=""></a>
									</span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<div class="post-display">
				<div class="columns is-multiline">
					<?php foreach($posts as $post) { ?>
						<div class="column is-one-third post-thumbnail">
							<a href="index.php?page=post&post_id=<?=$post['post_id']?>">
								<img src="app/assets/img/posts/<?=$post['path']?>" class="thumbnail">
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</main>
</body>