<?php
include 'connection.php';

$conn = getConnection();

$nama = $_GET["nama"];

try {
    $statement = $conn->prepare("SELECT * FROM mahasiswa WHERE nama = :nama;");
    $statement->bindParam(':nama', $nama);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $result = $statement->fetch();

    if($result){
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        $response["message"] = "nama kurang lengkap atau tidak ada dalam database";
        echo json_encode($response,JSON_PRETTY_PRINT);
    }

} catch (PDOException $e) {
    echo $e;
}