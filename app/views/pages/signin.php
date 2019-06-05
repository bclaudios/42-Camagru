<?php require_once(__DIR__."/../layouts/header.php"); ?>
<body>
	<main class="section" id="signup-section">
        <div class="container sign-container">
                <div class="media">
                    <div class="media-content">
                        <div class="content">
                            <a href="index.php"><h1 class="title" id="signup-title">Camagru</h1></a>
                        </div>
                    </div>
                </div>
			<form>
                <div class="edit-section" id="signin-input">
                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" placeholder="Username" id="input-login" required>
                        </div>
                    </div>
			    	<div class="field">
                        <div class="control">
                            <input type="password" class="input" placeholder="Password" id="input-passwd" required>
                        </div>
                        <a href=""><p>Forgot your password ?</p></a>
                    </div>
			    	<div class="field">
                        <label for="" class="label blank"></label>
                        <div class="control">
                            <button class="button is-primary" id="signin-btn">Connection</button>
                        </div>
                    </div>
                </div>
			</form>
        </div>
    </main>
    <div class="section" id="already-section">
        <div class="container sign-container">
            <p>Not a member yet ? <a href="index.php?page=signUp">Sign up here</a></p>
        </div>
    </div>
</body>
<script src="app/assets/js/signin.js"></script>