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

        if (!empty($_POST['jmeno']) && !empty($_POST['prijmeni']) && !empty($_POST['adresa']) && !empty($_POST['platba']))
        {
            $jmeno = filter_var($_POST["jmeno"], FILTER_SANITIZE_STRING);
            $prijmeni = filter_var($_POST["prijmeni"], FILTER_SANITIZE_STRING);
            $adresa = filter_var($_POST["adresa"], FILTER_SANITIZE_STRING);
            $platba = filter_var($_POST["platba"], FILTER_SANITIZE_STRING);

            unset($_SESSION['celkovaCena']);
            unset($_SESSION['pocetProduktu']);
            unset($_SESSION['nejvetsiId']);
            unset($_SESSION['kosik']);

            echo 
            "<div class='objednavka-hotova'>
                <h3>Vaše objednávka byla úspěšně dokončena.</h3>
                <a href=index.php class='button'>Zpět do obchodu!</a>
            </div>";
        }
        else
        {
            echo "<h3>Někde se stala chyba, nezadali jste údaje.</h3>
                <a href='objednavka.php'>Zpět k objednávce!</a>";
        }
        
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>