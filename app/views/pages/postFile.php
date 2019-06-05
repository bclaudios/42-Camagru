<?php require_once(__DIR__."/../layouts/header.php"); ?>
<body>
	<main class="section webcam-section">
		<div class="container webcam-container">
			<div class="columns">
				<div class="column is-1"></div>

				<!-- MONTAGE PART -->
				<div class="column is-8" id="render">
					<div class="card">
						<!-- FILE PREVIEW -->
						<div class="card-image">
							<div id="overlay">
								<div id="sticker"></div>
								<img id="uploaded_img" alt="Uploaded image" src="<?=$tmpPath?>">
								<canvas id="canvas" hidden></canvas>
							</div>
						</div>
						<div class="card-content" id="montage-ui">
								<button class="button is-primary" id="post-btn">Create your post !</button>
								<!-- STICKER SELECTION -->
								<?php
									foreach ($stickers as $stick)	{ ?>
										<img src='app/assets/img/stickers/<?=$stick?>' class='stickers'>
								<?php } ?>
						</div>
					</div>

					<!-- FILE UPLOAD PART -->
					<div class="card" id="nocam-card">
        				<div class="card-content">
							<p>No webcam ? Upload a picture here :</p>
							<form action="index.php?page=filePost" method="post" enctype="multipart/form-data">
							<div class="level">
								<div class="level-left">
									<div class="file has-name is-primary">
										<label class="file-label">
    										<input class="file-input is-primary" type="file" name="uploaded_img" accept="<?=$ext?>">
    										<span class="file-cta">
    											<span class="file-icon">
        											<img class="fas fa-upload" src="app/assets/img/	icon/	upload.png"></i>
      											</span>
    											<span class="file-label">
													Choose a picture (1 Mo max. | .png)
												</span>
											</span>
										</label>
									</div>
								</div>
								<div class="level-right">
									<button class="button is-primary" id="post-btn">Upload Picture</button>
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
	<script type="text/javascript" src="/app/assets/js/postFile.js"></script>
	<script type="text/javascript" src="/app/assets/js/stickers.js"></script>
</body>