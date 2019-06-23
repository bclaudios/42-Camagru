<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<main class="section">
    <div class="container sign-container">
        <div class="media">
            <div class="media-content">
                <div class="content">
                    <h2 class="subtitle">
                        Reset your password
                    </h2>
                </div>
            </div>
        </div>
        <form>
            <div class="edit-section" id="reset-section">
               <div class="field">
                    <label class="label">Please, enter your username below :</label>
                    <div class="control">
                        <input type="text" class="input" placeholder="Username" id="input-login" required>
                    </div>
                </div>
			    <div class="field">
                    <div class="control">
                        <button class="button is-primary" id="rstPasswd-btn">Reset Password</button>
                    </div>
                </div>
            </div>
		</form>
    </div>
<?php require_once(__DIR__."/../layouts/footer.php");?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script type="text/javascript" src="/app/assets/js/resetPasswd.js"></script>
