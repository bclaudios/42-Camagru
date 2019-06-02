<div class="comment content" id="<?=$comment['comment_id']?>">
	<div class="level">
        <div class="level-left">
	    <!-- USERNAME -->
            <a href="index.php?page=profil&login=<?=$comment['login']?>">
                <strong><?= $comment['login'] ?></strong>
            </a>
        <!-- POST TIME -->
	        <small><i><?= $comment['date'] . " " . $comment['time'] ?></i></small><br>
        </div>
        <!-- DELETE COMMENT BUTTON -->
        <?php if (isset($_SESSION['user']) && $comment['login'] === $_SESSION['user']) {?>
        <div class="level-right">
            <button class="button delete-comment">X</button>
        </div>
        <?php } ?>
    </div>
        <?= $comment['comment'] ?>
	    <!-- COMMENT -->
	</p>
</div>