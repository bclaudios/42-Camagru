<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<body>
	<main class="section webcam-section">
		<div class="container webcam-container">
			<div class="columns">
				<div class="column is-1"></div>

				<!-- MONTAGE PART -->
				<div class="column is-8" id="render">
					<div class="card" id="webcam-card" hidden>
						<!-- WEBCAM PREVIEW -->
						<div class="card-image">
							<div id="overlay">
								<div id="sticker"></div>
								<video id="webcam" autoplay></video>
								<canvas id="canvas" hidden></canvas>
							</div>
						</div>
						<div class="card-content" id="montage-ui">
								<button class="button is-primary" id="post-btn">Create your post !<span class="file-icon" id="post-icon">
        											<img class="fas fa-upload" src="app/assets/img/	icon/	instagram-white.svg" ></i>
      											</span></button>
								<!-- STICKER SELECTION -->
								<div class="stickers-container">
								<?php
									foreach ($stickers as $stick)	{ ?>
										<img src='app/assets/img/stickers/<?=$stick?>' class='stickers'>
								<?php } ?>
								</div>
						</div>
					</div>

					<!-- FILE UPLOAD PART -->
					<div class="card" id="nocam-card">
        				<div class="card-content">
						<?php if (isset($sizeError) && $sizeError == true) { ?>
							<div class="notification is-warning">
								<p>Selected file is too big. Maximum size : 1Mo</p>
							</div>
						<?php } if (isset($fileError) && $fileError == true) { ?>
							<div class="notification is-warning">
								<p>Selected file is not a .png. Please, select another file to upload.</p>
							</div>
							<?php } if (isset($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
							<div class="notification is-warning">
								<?=$_SESSION['error']?>
							</div>
							<?php $_SESSION['error'] = null; } ?>
							<p>No webcam ? Upload a picture here ( .png | Max size: 1 Mo) :</p>
							<form action="index.php?page=filePost" method="post" enctype="multipart/form-data">
							<div class="level">
								<div class="level-left">
									<div class="file has-name is-primary">
										<label class="file-label">
    										<input class="file-input is-primary" id="file-input" type="file" name="uploaded_img" accept="<?=$ext?>" required>
    										<span class="file-cta">
    											<span class="file-icon">
        											<img class="fas fa-upload" src="app/assets/img/	icon/download.svg"></i>
      											</span>
    											<span class="file-label">
													Choose a picture
												</span>
											</span>
											<span class="file-name" id="file-name">
												...
   											</span>
										</label>
									</div>
								</div>
								<div class="level-right">
									<button class="button is-primary">
    											<span class="file-icon">
        											<img class="fas fa-upload" src="app/assets/img/	icon/upload.svg"></i>
      											</span>
												Upload Picture</button>
								</div>
							</form>
							</div>
						</div>
   					</div>
				</div>

				<!-- PREVIOUS POST PREVIEW -->
				<div class="column is-3">
					<div class="card">
						<div class="card-contant">
							<div id="post-view">
								<?php foreach ($lastPosts as $post)	{?>
									<a href="index.php?page=post&post_id=<?=$post['post_id']?>" class='image'>
										<img src='/app/assets/img/posts/<?=$post['path']?>'>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="column is-1"></div>
			</div>
		</div>
	</main>
<?php require_once(__DIR__."/../layouts/footer.php");?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>"/>
<script type="text/javascript" src="/app/assets/js/postWebcam.js"></script>
<script type="text/javascript" src="/app/assets/js/stickers.js"></script>