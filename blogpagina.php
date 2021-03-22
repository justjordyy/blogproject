<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testdatabase";
    
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $blogid = $_GET["blogid"];

    $view = "blogpaginaView.php";

    


?>