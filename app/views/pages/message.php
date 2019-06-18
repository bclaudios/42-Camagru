<?php require_once(__DIR__."/../layouts/header.php"); 
$token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$_SESSION['token'] = $token;
?>
<main class="section">
    <div class="container edit-container">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">
                    <h2 class="subtitle"><?=$messageTitle?></h2>
                </div>
            </div>
            <div class="card-content">
                <div class="content">
                    <p><?=$message?></p>
                    <a href="index.php">Back to home page</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once(__DIR__."/../layouts/footer.php");?>