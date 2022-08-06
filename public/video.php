<?php

    if(isset($_GET['id']))
    {
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
            $sth = $conn->prepare("SELECT * FROM videos WHERE id = '{$_GET['id']}'");
            $sth->execute();

            $result = $sth->fetchAll();
        }catch (PDOException $error) {
            echo $error->getMessage();
        }
    }else {
        echo 'no video found';
        die();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/tailwind.css">
</head>
<body>
    <div class="w-screen h-screen flex items-center justify-center">
        <div class="w-3/6 p-5 bg-white shadow-xl rounded-xl">
            <video width="320" height="240" controls class="w-full h-auto rounded-xl object-cover">
                <source src="./../proccess/videos/<?php echo $result[0]['video'] ?>" type="video/mp4">
                <source src="./../proccess/videos/<?php echo $result[0]['video'] ?>" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>