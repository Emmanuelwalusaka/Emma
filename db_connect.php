<?php
$host = " Emma-254-web.infinityfree.me";
$username = "if0_43306074 ";
$password = "9nhwpNt4ygaqMl";
$database = "emma_web";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed.");
}
?>