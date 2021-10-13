<?php
    require_once "loginAndRegistration.php";
    require_once "kosikFunkce.php";

    //session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b6917811e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <title>Eshop</title>
</head>
<body>
    <?php
        include "header.php";
        include "products.php";
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>