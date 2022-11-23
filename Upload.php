<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a href="Index.php">Back</a>
<?php
  session_start();
if (isset($_SESSION['user'])) {


  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "database";
  $conn = new mysqli($servername, $username, $password, $dbname);
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Checkar om filen är en bild
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Kollar om den redan finns
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Kollar filstorlek
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Dubbe checka uploadOK 
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

  // Om inga fel, ladda up fil
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "<br>The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])).  " has been uploaded.";
      $text = $_SESSION["user"] . ";" . $target_file . "\n";
      $useruploads = fopen("uploads/useruploads.txt", "a+") or die("Unable to open file!");
      fwrite($useruploads, $text);
      fclose($useruploads);
      if($_SESSION["user"] == "holros") {
          $sql = "INSERT INTO uploads (filename, user, uploadtime, snuskig)
          VALUES ('$target_file', '" . $_SESSION["user"] . "', NOW(), TRUE)";
          $conn->query($sql);
      }
      else {
        $sql = "INSERT INTO uploads (filename, user, uploadtime) VALUES ('$target_file', '" . $_SESSION["user"] . "', NOW())";
        $result = $conn->query($sql);
      }
  } else {
      echo "Sorry, there was an error uploading your file.";
    }  
  }

} else {
  echo "You have not logged in.";
}
session_destroy();
?>


</body>
</html>