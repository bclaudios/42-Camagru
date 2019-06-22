<?php 
if (!isset($_SESSION['user']))
    header("Location: http://localhost/index.php");
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
require_once(__DIR__."/../layouts/header.php");

$user['notif'] = $user['notif'] == 1 ? "checked='true'" : "";
?>

    <main class="section">
        <div class="container edit-container">
			
			<!-- HEADER -->
            <div class="edit-section" id="profil-edit-header">
				<div class="columns">
					<div class="column is-4">
						<p class="image is-96x96">
							<img class="is-rounded" src="app/assets/img/profil/<?=$user ['profilPic']?>" alt="">
						</p>
					</div>
					<div class="column is-8 has-text-centered">
						<h2 id="header-login"><?=$user['login']?></h2>
					</div>
				</div>
			</div>

			<!-- PHOTO EDIT -->
			<div class="edit-section" id="profil-edit-photo">
				<div class="columns">
					<div class="column is-4">
						<label for="" class="label">Profil Photo</label>						
					</div>
					<div class="column is-8">
						<div class="field">
							<div class="control">
								<form action="index.php?action=updatePic" method="post" enctype="multipart/form-data">
									<div class="columns">
										<div class="column is-7">
											<div class="file has-name is-primary">
												<label class="file-label" style="width:100%;">
													<input class="file-input is-primary" type="file" name="uploaded_img" 	accept=".jpg">
													<span class="file-cta has-text-centered" id="photo-selector">
														<span class="file-icon">
															<img class="fas fa-upload" src="app/assets/img/icon/upload.svg"></i>
														</span>
														<span class="file-label has-text-centered">
															Select Profil Photo
														</span>
													</span>
												</label>
											</div>
										</div>
										<div class="column is-5">
											<button class="button is-primary" type="submit">Update Photo</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- INFOS EDIT -->
			<div class="edit-section" id="profil-edit-infos">
				<!-- INFOS EDIT - USERNAME -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
							<label for="" class="label">Username</label>
						</div>
						<div class="column is-8">
							<div class="control">
								<input type="text" class="input" id="input-login" value="<?=$user['login']?>">
							</div>
						</div>
					</div>
				</div>
				<!-- INFOS EDIT - E-MAIL -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
                    <label for="" class="label">E-mail</label>
						</div>
						<div class="column is-8">
							<div class="control">
                        		<input type="text" class="input" id="input-email" value="<?=$user['email']?>">
							</div>
						</div>
					</div>
				</div>
				<!-- INFOS EDIT - NOTIFICATION -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
                    		<label for="" class="label">Notification</label>
						</div>
						<div class="column is-8">
							<div class="control"><div class="checkbox">
                        		<input type="checkbox" id="input-notif" <?=$user['notif']?>>
                            		<span>Receive notification by email</span>
                    			</div>
							</div>
						</div>
					</div>
				</div>
				<!-- INFOS EDIT - SUBMIT -->
				<div class="columns">
					<div class="column is-8 is-offset-4">
						<div class="columns">
							<div class="column is-5">
								<div class="control">
									<button class="button is-primary" id="update-infos">Update infos</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

            <!-- PASSWORD EDIT -->
            <div class="edit-section" id="profil-edit-passwd">
				<!-- PASSWORD EDIT - ACTUAL -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
                    <label for="" class="label">Actual password</label>
						</div>
						<div class="column is-8">
                    		<div class="control">
                    		    <input type="password" class="input" id="input-passwd">
                    		</div>
						</div>
					</div>
				</div>
				<!-- PASSWORD EDIT - NEW -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
                    		<label for="" class="label">New password</label>
						</div>
						<div class="column is-8">
                    		<div class="control">
                        		<input type="password" class="input" id="input-newPasswd">
                    		</div>
						</div>
					</div>
				</div>
				<!-- PASSWORD EDIT - NEW CONFIRMATION -->
				<div class="field">
					<div class="columns">
						<div class="column is-4">
                    <label for="" class="label">Confirm password</label>
						</div>
						<div class="column is-8">
                    		<div class="control">
                        		<input type="password" class="input" id="input-newPasswdConf">
                    		</div>
						</div>
					</div>
				</div>
				<!-- PASSWORD EDIT - RESTRICTION -->
				<div class="field">
					<div class="columns">
						<div class="column is-8 is-offset-4">
							<div class="notif">
								<p>
									Your password must contain at least : <br>
									- 8 characters <br>
									- 1 uppercase letter <br>
									- 1 lowercasse letter <br>
									- 1 digit
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- PASSWORD EDIT - SUBMIT -->
				<div class="columns">
					<div class="column is-8 is-offset-4">
						<div class="columns">
							<div class="column is-5">
								<div class="control">
                        			<button class="button is-primary" id="update-passwd">Update password</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

            <!-- ACCOUNT SUPRESSION -->
            <div class="edit-section" id="profil-edit-delete">
				<div class="columns">
					<div class="column is-4">
                    	<label for="" class="label">Delete your account</label>
					</div>
					<div class="column is-8">
						<div class="columns">
							<div class="column is-5">
								<div class="control">
                        			<button class="button is-danger" id="delete-account">
										Delete account</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
        </div>
    </main>
<?php require_once(__DIR__."/../layouts/footer.php"); ?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script type="text/javascript" src="/app/assets/js/profil-edit.js"></script>