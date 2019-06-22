<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<body>
    <main class="section">
		<div class="container" id="profil-container">

			<!-- PROFIL INFOS -->
			<div id="profil-header">
				<div class="columns">
					<!-- PROFIL PIC -->
					<div class="column is-1">
						<figure class="image is-128x128 is-rounded" id="profil-pic">
							<img src="app/assets/img/profil/<?=$user['profilPic']?>" alt="">
						</figure>
					</div>

					<div class="column is-10">
						<!-- PROFIL LOGIN -->
						<div class="has-text-centered">
							<h2 id="header-login">
								<?php if (isset($_SESSION['user']) && $_SESSION['user'] === $user['login']) {?>
									<span class="icon is-medium">
										<a href="index.php?page=editProfil"><img src="app/assets/img/icon/settings.svg" class="image is-32x32"></a>
									</span>
								<?php } ?>
								<?=$user['login']?>
							</h2>
						</div>
						<!-- PROFIL STATS -->
						<nav class="level">
							<div class="level-item has-text-centered">
								<div>
									<p class="heading stats-heading">Publications</p>
									<p class="subtitle"><strong><?=sizeof($posts)?></strong></p>
								</div>
							</div>
							<div class="level-item has-text-centered">
								<div>
									<p class="heading stats-heading">Likes</p>
									<p class="subtitle"><strong><?=$likeCount?></strong></p>
								</div>
							</div>
							<div class="level-item has-text-centered">
								<div>
									<p class="heading stats-heading">Comments</p>
									<p class="subtitle"><strong><?=$commentCount?></strong></p>
								</div>
							</div>
						</nav>
					</div>

					<!-- PROFIL SETTINGS -->
					<div class="column is-1">
					</div>
				</div>
			</div>

			<!-- POST DISPLAY -->
			<div id="profil-post">
				<div class="columns is-multiline">
					<?php foreach($posts as &$post) { ?>
						<div class="column is-one-third">
							<a href="index.php?page=post&post_id=<?=$post['post_id']?>">
								<img src="app/assets/img/posts/<?=$post['path']?>">
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</main>
<?php require_once(__DIR__."/../layouts/footer.php");?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>"/>