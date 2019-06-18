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
							<p>Sign up and start sharing your pictures with your friends !</p>
                        </div>
                    </div>
                </div>
			<form>
                <div class="edit-section" id="signup-input">
                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" placeholder="Username"     id="input-login">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" placeholder="E-mail"   id="input-email">
                        </div>
                    </div>
			    	<div class="field">
                        <div class="control">
                            <input type="password" class="input" placeholder="Password"     id="input-passwd">
                        </div>
                    </div>
			    	<div class="field">
                        <div class="control">
                            <input type="password" class="input" placeholder="Password  Confirmation" id="input-passwdConf">
                        </div>
                    </div>
                        <div class="notif">
                            <p>
                                Your password must contain at least : <br>
                                - 8 characters <br>
                                - 1 uppercase letter <br>
                                - 1 lowercasse letter <br>
                                - 1 digit
                            </p>
                        </div>
			    	<div class="field">
                        <div class="control">
                            <button class="button is-primary" id="signup-btn" type="submit">Register</button>
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
<?php require_once(__DIR__."/../layouts/footer.php");?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script src="app/assets/js/signUp.js"></script>