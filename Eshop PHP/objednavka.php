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
    <title>Objednavka</title>
</head>
<body>
    <?php
        include "header.php";
    ?>
    <div class="objednavka-container">
        <form class="login-form" action="objednavkaHotova.php" method="POST">
            <label for="jmeno">Jméno:</label>
                <input type="text" name="jmeno" required>
            <label for="prijmeni">Příjmení</label>
                <input type="text" name="prijmeni" required>
            <label for="Adresa">Adresa</label>
                <input type="text" name="adresa" required>
            <label for="">Způsob platby</label>
            <select name="platba" name="platba" required>
                <option value="1">Dobírka - Hotovost</option>
                <option value="2">Dobírka - Kartou</option>
                <option value="3">Bankovní převod</option>
                <option value="4">Online Kartou</option>
            </select>
            <input class="button" type="submit" id="objednavka_vyplnena" name="objednavka_vyplnena" value="Dokončit objednávku">
        </form>
    </div>
    <?php
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>