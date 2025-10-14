<?php
$link = mysqli_connect("localhost", "root", "", "login_demo2");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>