<?php
    function changeUserInfo($POST, $uzivatelID, $uzivatelJmeno, $conn)
    {
        if (!empty($_GET['action']) && !empty($_GET['id']))
        {
            if ($_GET['action'] == "deleteUser" && $_GET['id'] == $uzivatelID)
            {
                $sql = "DELETE FROM Uzivatel WHERE id_uzivatel = $uzivatelID AND uzivatel_jmeno = '$uzivatelJmeno'";
                sqlQuery($conn, $sql);
                unset($_SESSION['uzivatelID']);
                unset($_SESSION['name']);
                header("Location: index.php");
                return $sql;
            }
            else 
                echo "Tento účet nelze smazat";
        }
        else if (!empty($POST['changedPassword']))
        {
            $newPassword = filter_var($_POST['changedPassword'], FILTER_SANITIZE_STRING);
            $newPassword = md5($newPassword);
            $sql = "UPDATE Uzivatel SET uzivatel_heslo = '$newPassword' WHERE id_uzivatel = $uzivatelID AND uzivatel_jmeno = '$uzivatelJmeno'";

            return $sql;
        }
        else if (!empty($POST['changedEmail']))
        {
            $newEmail = filter_var($_POST['changedEmail'], FILTER_SANITIZE_STRING);
            $sql = "UPDATE Uzivatel SET uzivatel_email = '$newEmail' WHERE id_uzivatel = $uzivatelID AND uzivatel_jmeno = '$uzivatelJmeno'";

            return $sql;
        }

        else
            return;
    }

    function sqlQuery($conn, $sql)
    {
        if ($conn->query($sql))
        {
            echo "<div class='error-container'><div class='error'>Úspěšně jste změnili Vaše údaje</div></div>";
        }
    }

    function checkIfIsAdmin($conn, $userId, $userName)
    {
        if (is_numeric($userId))
        {
            $userId = filter_var($userId, FILTER_SANITIZE_STRING);
            $userName = filter_var($userName, FILTER_SANITIZE_STRING);
            $sql = "SELECT bAdmin FROM Uzivatel WHERE id_uzivatel = $userId AND uzivatel_jmeno = '$userName' LIMIT 1";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($row['bAdmin'] == 1)
                $_SESSION['admin'] = 1;
            else
                $_SESSION['admin'] = 0;
        }
    }

    function printUsers($conn, $bAdmin)
    {
        $i = 0;
        if ($bAdmin == 1)
        {
            $sql = "SELECT id_uzivatel, bAdmin, uzivatel_jmeno, uzivatel_email FROM Uzivatel";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                echo 
                "<div class='admin'>
                <table class='user-panel'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role</th>
                            <th>Uživatelské jméno</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>";
                while ($row = $result->fetch_assoc())
                {
                    echo 
                    "<tr>
                        <td>$row[id_uzivatel]</td>
                        <td>";
                            if ($row['bAdmin'] == 1)
                                echo "Admin";
                            else
                                echo "Uživatel";
                        echo 
                        "</td>
                        <td>$row[uzivatel_jmeno]</td>
                        <td>$row[uzivatel_email]</td>
                        <td>
                            <a href='userPanel.php?userId=$row[id_uzivatel]&userName=$row[uzivatel_jmeno]'><i class='fas fa-users-cog'></i></a>
                        </td>
                    </tr>";
                    $i++;
                }
                echo "</table>
                </div>";
            }
        }
    }

    function printUserPanel($conn, $uzivatelID, $uzivatelJmeno)
    {
        if (is_numeric($uzivatelID))
        {
            $uzivatelID = filter_var($uzivatelID, FILTER_SANITIZE_STRING);
            $uzivatelJmeno = filter_var($uzivatelJmeno, FILTER_SANITIZE_STRING);
            $sql = "SELECT * FROM Uzivatel WHERE uzivatel_jmeno='$uzivatelJmeno' AND id_uzivatel=$uzivatelID LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                echo
                "<div class='adminPanel'>
                    <div class='adminHead'>
                        <h1>Karta uživatele</h1>
                        <div class='button button-a'>";
                        if ($_SESSION['admin'] == 1) 
                            echo "<a href='adminPanel.php'>Zpět</a>";
                        else
                            echo "<a href='index.php'>Zpět</a>";
                    
                        echo "</div>
                    </div>
                    <table class='user-panel'>
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>$row[id_uzivatel]</td>
                                <td><!--<a href='userPanel.php?action=deleteUser&id=$uzivatelID'>Smazat účet</a>--></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>"; 
                                    if ($row['bAdmin'] == 0)
                                        echo "Uživatel";
                                    else
                                        echo "Admin";
                                echo "
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Uživatelské jméno</th>
                                <td>$row[uzivatel_jmeno]</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>$row[uzivatel_email]</td>
                                <td>
                                    <form class='user-form' action='userPanel.php?userId=$row[id_uzivatel]&userName=$row[uzivatel_jmeno]' method='POST' id='zmenitEmail'>
                                        <input type='email' name='changedEmail' required>
                                        <button class='button2' type='submit' form='zmenitEmail' value='Submit'>Změnit email</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Heslo</th>
                                <td>Změnit heslo</td>
                                <td>
                                    <form class='user-form' action='userPanel.php?userId=$row[id_uzivatel]&userName=$row[uzivatel_jmeno]' method='POST' id='zmenitHeslo'>
                                        <input type='password' name='changedPassword' required>
                                        <button class='button2' type='submit' form='zmenitHeslo' value='Submit'>Změnit heslo</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>";
            }
        }
        
    }
?>