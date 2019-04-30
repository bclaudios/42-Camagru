<?php require_once("elements/header.php");
?>
<body>
    <main>
        <?php foreach ($user as $key => $value)  {
            echo "<p>" . $key . " : " . $value . "</p><br>";
        } ?>
        <a href="index.php?page=changeinfo">Edit informations</a>
    </main>
</body>