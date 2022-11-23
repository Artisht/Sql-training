<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn -> connect_error)
{
    die("connection to dataase failed :(");
}


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
  
$login_success = false;
$full_name = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($row["username"] == $_POST["username"] &&
					$row["password"] == $_POST["password"]) {
			$login_success = true;
			$full_name = $row["name"];
                    echo "Welcome $full_name";
					echo "<a href='index.php'>Exit</a>";
			}
	}
} else {
    echo "0 results";
}
if($login_success) {
	session_start();
	$_SESSION["username"] = $_POST["username"];
}
$conn->close();



?>