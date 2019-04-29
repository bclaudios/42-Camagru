<?php require_once("elements/header.php");
$userInfos = $_SESSION['logguedUser'];
?>
<body>
    <main>
        <?php foreach ($userInfos as $key => $value)  {
            echo "<p>" . $key . " : " . $value . "</p><br>";
        } ?>
        <a href="index.php?page=changeinfo">Edit informations</a>
    </main>
</body>