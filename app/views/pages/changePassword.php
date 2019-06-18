<?php
if (!isset($_SESSION['resetUser']))
    header("Location: http://localhost/index.php");
require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
    <main class="section">
        <div class="container edit-container">
            <!-- PASSWORD EDIT -->
            <div class="media">
            <div class="media-content">
                <div class="content">
                    <h2 class="subtitle">
                        Reset your password
                    </h2>
                </div>
            </div>
        </div>
            <div class="edit-section" id="passwd-edit">
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
        </div>
    </main>
<?php require_once(__DIR__."/../layouts/footer.php");?>
<input type="hidden" name="token" id="token" value="<?= $token; ?>" />
<script type="text/javascript" src="/app/assets/js/editProfil.js"></script>