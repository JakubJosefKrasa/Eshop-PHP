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
    <title>Registrace</title>
</head>
<body>
    <?php
        include "header.php";
    ?>

    <form action="register.php" method="POST" autocomplete="off" class="login-form">
        <?php
            if(count($errors) == 1)
            {
        ?>
                <div class="error-container">
                    <div class='error'>
                    <?php
                        foreach($errors as $showerror)
                        {
                            echo $showerror;
                        }
                    ?>
                    </div>
                </div>
        <?php
            }
            elseif(count($errors) > 1){
        ?>
            <div class="error-container">
                <div class='error'>
                <?php
                foreach($errors as $showerror){
                    ?>
                    <li><?php echo $showerror; ?></li>
                    <?php
                }
                ?>
                </div>
            </div>
            <?php
        }
        ?>
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