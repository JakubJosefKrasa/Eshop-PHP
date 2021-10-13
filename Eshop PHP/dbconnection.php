<?php
    function connectDb()
    {
        $servername = "dbs.spskladno.cz";
        $username = "student23";
        $password = "spsnet";
        $dbname = "vyuka23";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) 
            die("Connection failed: " . $conn->connect_error);
        
        $conn->set_charset("utf8mb4");
        return $conn;
    }
?>