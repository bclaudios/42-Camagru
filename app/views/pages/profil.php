<?php require_once("app/views/layouts/header.php"); ?>
<body>
    <main>
        <?php foreach ($user as $key => $value)  {
            echo "<p>" . $key . " : " . $value . "</p><br>";
        } ?>
        <a href="index.php?page=editProfil">Edit informations</a>
    </main>
</body>