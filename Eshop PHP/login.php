<?php
    include "loginAndRegistration.php";
    include "kosikFunkce.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b6917811e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Přihlášení</title>
</head>
<body>
    <?php
        include "header.php";
    ?>

    <form action="login.php" method="POST" autocomplete="off" class="login-form">
        <?php
            if (count($errors) > 0)
            {
                echo "<div class='error'>";
                foreach ($errors as $error)
                    echo $error;
            }
            echo "</div>";
        ?>
        <input type="email" name="email" placeholder="Zadejte email:" required>
        <input type="password" name="password" placeholder="Zadejte heslo:" required>
        <button type="submit" class="button" name="login" required>Přihlásit</button>
        <a href="register.php" class="button">Registrace</a>
    </form>
    <?php
        include "footer.php";
        $conn->close();
    ?>
</body>
</html>