<?php
include 'connect.php';
$DB = new Database();
$hotelName = $_POST['hotelName'];
$place = $_POST['place'];
$address = $_POST['address'];
$message = $_POST['message'];
$insertQuery = "INSERT INTO sponsers(HotelName,message,place,address)
    VALUES ('$hotelName','$message','$place','$address')";
if ($DB->save($insertQuery)) {
    header("location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>