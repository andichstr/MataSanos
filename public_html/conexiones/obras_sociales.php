<?php
require_once ('configure.php');
require_once ('conexion.php');

$serverName= host;
$dbName= database;
$userName= user;
$password= password;
$tos= tabla_obras_sociales;




try {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);

        $sql = "SELECT O.id_obra_social, O.descripcion FROM $tos O ";
        
        foreach ($conn->query($sql) as $row){
            
            echo "<option value=".$row["id_obra_social"].">".$row["descripcion"]."</option>";
        }
    }
catch(PDOException $e){
   echo "Error: " . $e->getMessage();
   }
