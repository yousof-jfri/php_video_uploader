<?php

// data base
$serverName = 'localhost';
$userName = 'root';
$password = '';
$dbname = 'upload_project';


// connect to data base with pdo
try {
    $conn = new PDO("mysql:host=$serverName;dbname=$dbname", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fetch all the videos from the database
    $sth = $conn->prepare("SELECT * FROM videos");
    $sth->execute();

    $result = $sth->fetchAll();

    echo json_encode($result);
}catch (PDOException $error) {
    echo $error->getMessage();
}

$conn = null;