<?php
    include "loginAndRegistration.php";
    if (isset($_GET['vKey']))
    {
        $vKey = $_GET['vKey'];
        $sql_SelectAcc = "SELECT uzivatel_kod, uzivatel_verified FROM Uzivatel WHERE uzivatel_kod = '$vKey' AND uzivatel_verified = 0 LIMIT 1";
        $result = $conn->query($sql_SelectAcc);

        if ($result->num_rows == 1)
        {
            $sql_verify = "UPDATE Uzivatel SET uzivatel_verified = 1 WHERE uzivatel_kod = '$vKey' LIMIT 1";
            $update = $conn->query($sql_verify);

            if ($update)
                echo "Váš účet je aktivován";
            else
                echo $conn->error;
        }
        else
            echo "Tento účet buď neexistuje nebo je již aktivovaný";
    }
    else
        die("Něco se nepovedlo");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b6917811e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Registrace</title>
</head>
<body>
    <?php
        include "header.php";
    ?>

    <form action="register.php" method="POST" autocomplete="off" class="login-form">
        <input type="text" name="name" placeholder="Zadejte uživatelské jméno:" required>
        <input type="email" name="email" placeholder="Zadejte email:" required>
        <input type="password" name="password1" placeholder="Zadejte heslo:" required>
        <input type="password" name="password2" placeholder="Potvrďte heslo:" required>
        <button type="submit" class="button" name="register">Registrovat</button>
        <a href="login.php" class="button">Přihlásit</a>
    </form>
    <?php
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>