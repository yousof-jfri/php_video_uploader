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

    // upload file
    if(isset($_FILES['file'])){
        
        $errors = array();
        $fileName = $_FILES['file']['name'];
        $fileTMPName = $_FILES['file']['tmp_name'];

        $tmpAddress = explode('.', $_FILES['file']['name']);
        $newfilename = round(microtime(true)) . '.' . end($tmpAddress);
        $file_ext = strtolower(end($tmpAddress));

        
        move_uploaded_file($fileTMPName, 'videos/' . $newfilename);
        echo 'success';
    }

    $name = $_POST['name'];
    $date = date('d-m-y h:i:s');
    
    // save file into database
    $sql = "INSERT INTO videos (name, video, created_at) VALUES ('{$name}', '{$newfilename}', '{$date}')";
    $conn->exec($sql);

}
catch (PDOException $error) {
    echo $error->getMessage();
}

$conn = null;
?>