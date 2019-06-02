<?php require_once(__DIR__."/../layouts/header.php"); ?>
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
                            <h2 class="title"><?=$user['login']?></h2>
                        </div>
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
                        <input type="checkbox" id="input-notif">
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
            <div class="edit-section">
               <div class="field">
                    <label for="" class="label">Actual password</label>
                    <div class="control">
                        <input type="password" class="input">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">New password</label>
                    <div class="control">
                        <input type="password" class="input">
                    </div>
                </div>
                <div class="field">
                    <label for="" class="label">New password confirmation</label>
                    <div class="control">
                        <input type="password" class="input">
                    </div>
                </div>
                <div class="field">
                <label for="" class="label blank"></label>
                    <div class="control">
                        <button class="button is-primary">Change password</button>
                    </div>
                </div>
            </div>
            <!-- ACCOUNT SUPRESSION -->
            <div class="edit-section">
                <div class="field">
                <label for="" class="label blank">Delete your account</label>
                    <div class="control">
                        <button class="button is-danger">Delete account</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script type="text/javascript" src="/app/assets/js/editProfil.js"></script>