<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<body>
	<main class="section" id="signup-section">
        <div class="container sign-container">
                <div class="media">
                    <div class="media-content">
                        <div class="content">
                            <a href="index.php"><h1 class="title" id="signup-title">Camagru</h1></a>
							<p>Inscrivez-vous pour voir les photos et vidéos de vos amis.</p>
                        </div>
                    </div>
                </div>
			<form>
                <div class="edit-section" id="signup-input">
                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" placeholder="Username"     id="input-login" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" placeholder="E-mail"   id="input-email" required>
                        </div>
                    </div>
			    	<div class="field">
                        <div class="control">
                            <input type="password" class="input" placeholder="Password"     id="input-passwd" required>
                        </div>
                    </div>
			    	<div class="field">
                        <div class="control">
                            <input type="password" class="input" placeholder="Password  Confirmation" id="input-passwdConf" required>
                        </div>
                    </div>

			    	<div class="field">
                        <label for="" class="label blank"></label>
                        <div class="control">
                            <button class="button is-primary" id="signup-btn">Register</button>
                        </div>
                    </div>
                </div>
			</form>
        </div>
    </main>
    <div class="section" id="already-section">
        <div class="container sign-container">
            <p>Already have an account ? <a href="index.php?page=signIn">Click here</a></p>
        </div>
    </div>
</body>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script src="app/assets/js/signUp.js"></script>