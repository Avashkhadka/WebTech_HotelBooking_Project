<?php
$host='localhost';
$user='root';
$pass='';
$db='hotelbooking';
$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
    echo" Failed to connect database". mysqli_connect_error();
}
?>