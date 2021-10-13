<?php
    include "loginAndRegistration.php";
    include "kosikFunkce.php";
    include "userFunctions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b6917811e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Admin Panel</title>
</head>
<body>
    <?php
        include "header.php";
        if (!empty($_SESSION['uzivatelID']) && !empty($_SESSION['name']) && $_SESSION['admin'] == 1)
        {
            printUsers($conn, $_SESSION['admin']);
        }
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>