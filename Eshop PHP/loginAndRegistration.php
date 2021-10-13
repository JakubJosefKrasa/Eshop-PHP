<?php
    session_start();
    include "dbconnection.php";
    $conn = connectDb();
    //$email = "";
    //$name = "";
    $errors = array();

    if (isset($_GET['odhlasit']))
    {
        unset($_SESSION['name']);
        header('location: index.php');
    }

    if (isset($_POST['register']))
    {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $password1 = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
        $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);

        if (empty($name))
            array_push($errors, "Prosím zadejte uživatelské jméno!");
        if (empty($email))
            array_push($errors, "Prosím zadejte Váš email!");
        if (empty($email))
            array_push($errors, "Prosím zadejte heslo!");
        if (empty($name))
            array_push($errors, "Prosím zadejte heslo!");
        if ($password1 != $password2)
            array_push($errors, "Hesla se neshodují!");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            array_push($errors, "Neplatný email!");


        $vKey = md5(time() .$name);
        $password = md5($password1);

        $sql_AccExist = "SELECT uzivatel_jmeno, uzivatel_email FROM Uzivatel WHERE uzivatel_jmeno='$name' OR uzivatel_email='$email' LIMIT 1";
        $result = $conn->query($sql_AccExist);
        $user = $result->fetch_assoc();

        if ($user)
        {
            if ($user["uzivatel_jmeno"] === $name)
                array_push($errors, "Uživatelské jmnéno již existuje");
            
            if ($user["uzivatel_email"] === $email)
                array_push($errors, "Emailová adresa již existuje");
                
        }

        if (count($errors) == 0)
        {
            $sql_insertAcc = "INSERT INTO Uzivatel (uzivatel_jmeno, uzivatel_email, uzivatel_heslo, uzivatel_kod) VALUES 
            ('$name', '$email', '$password', '$vKey')";

            $result = $conn->query($sql_insertAcc); 
            if ($result)
            {
                $subject = "Potvrzení Emailu";
                $message = "<a href='http://xeon.spskladno.cz/~krasaj/eshop/verify.php?vKey=$vKey'>Aktivovat</a>";
                $sender = "Poslal: eshop@spskladno.cz \r\n";
                $sender = "MIME-Version: 1.0". "\r\n";
                $sender .= "Content-type: text/html; charset=UTF-8". "\r\n";

                if (mail($email, $subject, $message, $sender))
                {
                    $info = "Potvrzovací kod byl zaslán na Váš Email";
                    echo $info;
                }
            }
        }
    }

    if (isset($_POST['login']))
    {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        if (!empty($email) && !empty($password))
        {
            $cryptedPassword = md5($password);

            $sql_findAcc = "SELECT * FROM Uzivatel WHERE uzivatel_email = '$email' AND uzivatel_heslo = '$cryptedPassword' LIMIT 1";
            $result = $conn->query($sql_findAcc);

            if ($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                $verified = $row['uzivatel_verified'];
                $name = $row['uzivatel_jmeno'];
                $userId = $row['id_uzivatel'];

                if ($verified == 1)
                {
                    $_SESSION['name'] = $name;
                    $_SESSION['uzivatelID'] = $userId;
                    header("Location: index.php");
                }
                else
                    array_push($errors, "Účet není aktivovaný");
            }
            else
                array_push($errors, "Špatné heslo a email nebo účet neexistuje");
        }
        else
            array_push($errors, "Vyplňte údaje");
    }
?>