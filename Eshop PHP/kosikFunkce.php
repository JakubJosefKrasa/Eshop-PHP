<?php
    if (!empty($_GET['action']) && !empty($_GET['id']) && $_GET['id'] > 0 && $_GET['id'] <= $_SESSION['nejvetsiId']['id_produkty'])
    {
        if ($_GET['action'] == 'add')
        {
            addToCart($_GET['id']);
            header("Location: kosik.php");
        }

        if ($_GET['action'] == 'remove')
        {
            removeFromCart($_GET['id']);
            header("Location: kosik.php");
        }
    }

    function addToCart($id)
    {
        if (isset($_SESSION['kosik']))
        {
            if (!array_key_exists($id, $_SESSION['kosik']))
                $_SESSION['kosik'][$id]['pocet'] = 1;
            else
                $_SESSION['kosik'][$id]['pocet']++;
        }
        else
            $_SESSION['kosik'][$id]['pocet'] = 1;
    }

    function removeFromCart($id)
    {
        if (isset($_SESSION['kosik']))
        {
            if (array_key_exists($id, $_SESSION['kosik']))
            {
                if ($_SESSION['kosik'][$id]['pocet'] <= 1)
                    unset($_SESSION['kosik'][$id]);
                else
                    $_SESSION['kosik'][$id]['pocet']--;
            }
        }
    }

    function pocetProduktuKosik()
    {
        if (!empty($_SESSION['kosik']))
        {
            $total = 0;

            foreach ($_SESSION['kosik'] as $key => $value)
            {
                foreach($value as $key => $value)
                    $total += $value;
            }
            return $total;
        }
    }

    function celkovaCena($conn)
    {
        if (!empty($_SESSION["kosik"]))
        { 
            $celkovaCena = 0;

            foreach ($_SESSION['kosik'] as $key => $value)
            {
                $sql = "SELECT cena_produkt FROM Produkty WHERE id_produkty=$key";
                $result = $conn->query($sql);

                if (!empty($result) && $result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                        $celkovaCena += $value['pocet'] * $row['cena_produkt'];
                }
            }

            return $celkovaCena;
        }
    }

    function nejvetsiId($conn)
    {
        $sql = "SELECT id_produkty FROM Produkty ORDER BY id_produkty DESC LIMIT 1";
        $result = $conn->query($sql);
        $maxId = $result->fetch_assoc();

        return $maxId;
    }

    function vypsatKosik($conn)
    {
        if ((!empty($_SESSION["kosik"])))
        { 
            foreach ($_SESSION["kosik"] as $key => $value) 
            {
                $sql = "SELECT * FROM Produkty WHERE id_produkty=$key";
                $result = $conn->query($sql);

                if (!empty($result) && $result->num_rows > 0) 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        echo 
                        "<div class='product-kosik'>". 
                            "<div class='obrazek-kosik'>". 
                                "<img src='./img/$row[img_produkt]'>". 
                            "</div>".
                            "<div class='jmeno-product'>".
                                "<h3>".$row['nazev_produkt']."</h3>".
                            "</div>".
                            "<div class='product-pocet'>".
                                "<a href=?action=remove&id=".$row['id_produkty'].">" . "-" . "</a>" . 
                                "$value[pocet]".
                                "<a href=?action=add&id=".$row['id_produkty'].">" . "+" . "</a>". 
                            "</div>";
                            if ($value['pocet'] > 1)
                            {
                                echo "<div class='cena-ks'>". number_format($row['cena_produkt'], 0 , "" , " " ). " Kč/Ks </div>";
                            }
                            else 
                                echo "<div class='cena-ks'></div>";
                                echo "<div class='cena-vice-kusu'><h4>" . number_format($row['cena_produkt'] * $value['pocet'], 0 , "" , " " )  . " Kč</h4></div>" . 
                            "</div>";
                    }
                    //echo number_format ($_SESSION['celkovaCena'], 0 , "" , " " ) . " Kč";
                }

            }
            echo 
            "
            <div class='objednavka-celkova-cena'>
                <h3>K úhradě</h3>
                <h3 class='celkova-cena'>". number_format ($_SESSION['celkovaCena'], 0 , "" , " " ) . " Kč</h3>
            </div>
            <div class='objednavka-info'>
                <div class='objednavka-button'>
                    <h3><a href='index.php'>Zpět k nákupu</a></h3>
                </div>
                <div class='objednavka-button'>
                    <h3><a href='objednavka.php'>Pokračovat</a></h3>
                </div>
            </div>";
            //return ;
        }
        else 
            echo 
            "<div class='error-container'>
                <div class='error'>
                    Ještě nemáte žádné produkty v košíku
                </div>
            </div>";
        
    }
?>