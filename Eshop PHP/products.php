<?php
    function printItems($conn, $sql)
    {
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            echo "<div class='item-container'>";
            while ($row = $result->fetch_assoc())
            {
                echo 
                    "<div class='item'>".
                        "<div class='obrazek'>" . 
                            "<img src='./img/$row[img_produkt]'>" . 
                        "</div>" .
                        "<div class='item-popis'>".
                            "<div class='item-nazev'>".$row['nazev_produkt']."</div>".
                            "<div class='cena-container'>".
                                "<div class='item-cena'>".number_format ($row['cena_produkt'], 0 , "" , " ")." Kč</div>".
                                "<div class='kosik-icon'>".
                                    "<form method='POST' action='index.php?action=add&id=$row[id_produkty]'>".
                                        "<button type='submit' name='add_to_cart'>".
                                            "<i class='fas fa-shopping-basket fa'></i> Do košíku".
                                        "</button>".
                                    "</form>".
                                "</div>".
                            "</div>".
                        "</div>".
                    "</div>";
            }
            echo "</div>";
        }
    }

    function vyhledavani()
    {
        if (isset($_GET['druh']))
        {
            $druh = filter_var($_GET['druh'], FILTER_SANITIZE_STRING);
    
            $sql = "SELECT * FROM Produkty WHERE id_druh = '$druh'";

            return $sql;
        }
        else if (isset($_GET['hledat']))
        {
            $hledat = filter_var($_GET['hledat'], FILTER_SANITIZE_STRING);

            $sql = "SELECT * FROM Produkty WHERE Produkty.nazev_produkt LIKE '%$hledat%'";

            return $sql;
        }
        else 
        {
            $sql = "SELECT * FROM Produkty";
            
            return $sql;
        }
    }

    $sql = vyhledavani();
    printItems($conn, $sql);
?>