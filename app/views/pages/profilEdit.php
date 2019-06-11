<?php 
if (!isset($_SESSION['user']))
    header("Location: http://localhost/index.php");
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
require_once(__DIR__."/../layouts/header.php");
?>
    <main class="section">
        <div class="container edit-container">
            <!-- PROFIL PIC EDIT -->
            <div class="pic-edit">
                <div class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img class="is-rounded" src="app/assets/img/profil/<?=$user ['profilPic']?>" alt="">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <h2 class="title" id="title-login"><?=$user['login']?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="edit-section" id="pic-edit">
                <div class="field">
                    <label for="" class="label">Profil Photo</label>
                    <div class="control">
                    <form action="index.php?action=updatePic" method="post" enctype="multipart/form-data">
			    		<div class="level">
			    			<div class="level-left">
			    				<div class="file has-name is-primary">
									<label class="file-label" style="width:100%;">
    		    					    <input class="file-input is-primary" type="file" name="uploaded_img" accept=".jpg">
    		    					    <span class="file-cta">
    		    					    	<span class="file-icon">
        	    					    	    <img class="fas fa-upload" src="app/assets/img/icon/upload.png"></i>
      		    					    	</span>
    		    					    	<span class="file-label">
                                                Select Profil Photo
			    					    	</span>
			    					    </span>
                                   </label>
                                </div>
			    			</div>
			    		    <div class="level-right">
			            	    <button class="button is-primary" type="submit">Apply</button>
			    	        </div>
			            </div>
			    	</form>
                    </div>
                </div>
            </div>
            <!-- GENERAL INFOS EDIT -->
            <div class="edit-section" id="general-edit">
                <div class="field">
                    <label for="" class="label">Username</label>
                    <div class="control">
                        <input type="text" class="input" id="input-login" value="<?=$user['login']?>">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">E-mail</label>
                    <div class="control">
                        <input type="text" class="input" id="input-email" value="<?=$user['email']?>">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">Notification</label>
                    <div class="checkbox">
                        <input type="checkbox" id="input-notif" checked="<?=$user['notif']?>">
                        <strong>
                            Receive notification by email
                        </strong>
                    </div>
                </div>
                <div class="field">
                <label for="" class="label blank"></label>
                    <div class="control">
                        <button class="button is-primary" id="update-infos">Submit</button>
                    </div>
                </div>
            </div>
            <!-- PASSWORD EDIT -->
            <div class="edit-section" id="passwd-edit">
               <div class="field">
                    <label for="" class="label">Actual password</label>
                    <div class="control">
                        <input type="password" class="input" id="input-passwd">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">New password</label>
                    <div class="control">
                        <input type="password" class="input" id="input-newPasswd">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">New password confirmation</label>
                    <div class="control">
                        <input type="password" class="input" id="input-newPasswdConf">
                    </div>
                </div>
                <div class="field">
                <label for="" class="label blank"></label>
                    <div class="control">
                        <button class="button is-primary" id="update-passwd">Change password</button>
                    </div>
                </div>
            </div>
            <!-- ACCOUNT SUPRESSION -->
            <div class="edit-section" id="delete-edit">
                <div class="field">
                    <label for="" class="label">Delete your account</label>
                    <div class="control">
                        <button class="button is-danger" id="delete-account">Delete account</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script type="text/javascript" src="/app/assets/js/editProfil.js"></script>