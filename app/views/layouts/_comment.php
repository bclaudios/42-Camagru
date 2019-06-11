<div class="comment content" id="<?=$comment['comment_id']?>">
	<div class="level">
        <div class="level-left">
	    <!-- USERNAME -->
            <a href="index.php?page=profil&login=<?=$comment['login']?>" class='comment-login'>
                <strong><?= $comment['login'] ?></strong>
            </a>
        <!-- POST TIME -->
	        <small><i class="comment-time"><?= $comment['date'] . " " . $comment['time'] ?></i></small>
            <br>
        </div>
        <!-- DELETE COMMENT BUTTON -->
        <?php if (isset($_SESSION['user']) && $comment['login'] === $_SESSION['user']) {?>
            <div class="level-right">
		    		<a href="" class="comment-delete">X</a>
            </div>
        <?php } ?>
    </div>
	<!-- COMMENT -->
    <?= $comment['comment'] ?>
</div>