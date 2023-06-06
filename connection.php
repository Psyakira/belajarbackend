<?php
//connection.php
function getConnection (): PDO
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "data_mahasiswa";
    return new PDO("mysql:host=$servername;dbname=$database", $username, $password, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
}
?>