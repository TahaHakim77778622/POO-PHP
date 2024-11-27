<?php

$servername = "localhost";

$username = "root";

$password = "";

// Create connection

$conn = mysqli_connect($servername, $username,
$password);

// Check connection

if (!$conn) {

die("Connection failed: " .
mysqli_connect_error());

}

echo "Connected successfully";
// Create database

$sql = "CREATE DATABASE testDb";

if (mysqli_query($conn, $sql)) {

echo "Database created successfully";

} else {

echo "Error creating database: " .
mysqli_error($conn);

}
$query = "

CREATE TABLE Clients (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY
KEY,

firstname VARCHAR(30) NOT NULL,

lastname VARCHAR(30) NOT NULL,

email VARCHAR(50) UNIQUE,

password VARCHAR(80),

reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
ON UPDATE CURRENT_TIMESTAMP

)

";

if (mysqli_query($conn, $query)) {

echo "Table Clients created successfully";

} else {

echo "Error creating table: " .
mysqli_error($conn);

}
// hachage du mot de passe

$password = password_hash("amine123456",
PASSWORD_DEFAULT);

$sql = "INSERT INTO Clients (firstname,
lastname, email,password)

VALUES ('Amine', 'Ze',
'Amineze@gmail.com','$password')";

if (mysqli_query($conn, $sql)) {

echo "New record created successfully";

} else {

echo "Error: " . $sql . "<br>" .
mysqli_error($conn);

}
$password = password_hash("amine123456",
PASSWORD_DEFAULT);

$sql = "INSERT INTO Clients (firstname,
lastname, email, password)

VALUES ('John', 'Doe',
'john@example.com','$password');";

$sql .= "INSERT INTO Clients (firstname,
lastname, email,password)

VALUES ('Mary', 'Moe',
'mary@example.com','$password');";

$sql .= "INSERT INTO Clients (firstname,
lastname, email,password)

VALUES ('Julie', 'Dooley',
'julie@example.com','$password')";

if (mysqli_multi_query($conn, $sql)) {

echo "New records created successfully";

} else {

echo "Error: " . $sql . "<br>" .
mysqli_error($conn);

}