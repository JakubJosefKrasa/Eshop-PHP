<?php
    require_once "userFunctions.php";

    $_SESSION['pocetProduktu'] = pocetProduktuKosik();
    $_SESSION['celkovaCena'] = celkovaCena($conn);
    $_SESSION['nejvetsiId'] = nejvetsiId($conn);
    
    function writeType($conn)
    {
        $sql = "SELECT Druh.nazev_druh, Druh.id_druh FROM Druh ORDER BY Druh.id_druh ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                echo 
                "<li>
                    <a href=index.php?druh=".$row["id_druh"]." class='hover-link'>" . $row["nazev_druh"] . "</a>
                </li>";
            }
        }
    }

    if (!empty($_SESSION['uzivatelID']) && !empty($_SESSION['name']))
    {
        checkIfIsAdmin($conn, $_SESSION['uzivatelID'], $_SESSION['name']);
    }

    
    echo
        "<header>
            <div class='top-header'>
                <h1><a href='index.php' class='logo'>Eshop</a></h1>
                <div class='search'>
                    <form action='index.php' class='vyhledavani' method='get'>
                        <input type='text' name='hledat' id='hledat' placeholder='Vyhledat zboží'>
                        <button type='submit'><i class='fas fa-search'></i></button>
                    </form>
                </div>

                <div class='right-menu'>
                    <div class='kosik-outer'>
                        <a href='kosik.php' class='kosik'>
                            <i class='fas fa-shopping-basket fa-2x'></i>";
                            if (isset($_SESSION['pocetProduktu']))
                            {
                                echo "<div class='kosik-pocet'>". 
                                    $_SESSION['pocetProduktu'].
                                    "</div>";
                            }
                            echo 
                            "<div class='kosik-cena'>"; 
                                if (isset($_SESSION['celkovaCena'])) 
                                    echo number_format($_SESSION['celkovaCena'], 0 , "" , " ")." Kč"; 
                                else 
                                    echo "Košík"; 
                            echo 
                            "</div>
                        </a>
                    </div>
                    <div class='login'>";
                    if (isset($_SESSION['name']))
                    {
                        echo 
                        "<div class='login-inner'>
                            <h3>Vítej";
                            if (!empty($_SESSION['admin']) && $_SESSION['admin'] === 1)
                                echo "<a href='adminPanel.php'>".$_SESSION['name']."</a></h3>";
                            else
                                echo "<a href='userPanel.php?userId=$_SESSION[uzivatelID]&userName=$_SESSION[name]'>".$_SESSION['name']."</a></h3>";

                            echo "<a href='index.php?odhlasit=1'><i class='fas fa-sign-out-alt fa-lg'></i></a>
                        </div>";
                    }
                    else
                    {
                        echo "<a href='login.php'>Přihlásit</a>";
                    }
                    echo 
                    "</div>
                </div>
            </div>
        </header>";
        
?>

<nav>
    <div class="nav-bar">
        <ul class="nav-typ">
            <?php
                writeType($conn);
            ?>
        </ul>
    </div>
</nav>
