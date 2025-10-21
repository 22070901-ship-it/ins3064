<?php
$link = mysqli_connect("localhost", "root", "123456", "login_demo");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>