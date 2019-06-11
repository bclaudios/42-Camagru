<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<body>
    <main class="section">
		<div class="container profil-container">
				<div class="card profil-card">
					<div class="card-content">
						<div class="columns">
							<!-- PROFIL PIC -->
							<div class="column is-2">
								<figure class="image is-96x96 is-rounded">
									<img src="app/assets/img/profil/<?=$user['profilPic']?>" style="border-radius:10000px;" alt="">
								</figure>
							</div>
							<!-- USER INFOS -->
							<div class="column is-9">
								<h2 class="title"  id="profil-login"><?=$user['login']?></h2>
							</div>
							<div class="column is-1">
							<?php if (isset($_SESSION['user']) && $_SESSION['user'] === $user['login']) {?>
									<span class="icon is-medium">
										<a href="index.php?page=editProfil"><img src="app/assets/img/icon/settings.png" class="image" alt=""></a>
									</span>
									<?php } ?>
							</div>
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
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />