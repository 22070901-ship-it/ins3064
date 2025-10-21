<?php
session_start();

/* --- Kết nối CSDL --- */
$con = mysqli_connect('localhost', 'root', '', 'LoginReg');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

/* --- Nếu người dùng nhấn nút Đăng ký --- */
if (isset($_POST['register'])) {

    /* Lấy dữ liệu từ form đăng ký */
    $name       = $_POST['user'];
    $pass       = $_POST['password'];
    $student_id = $_POST['student_id'];
    $dob        = $_POST['dob'];
    $country    = $_POST['country'];

    /* Kiểm tra trùng username */
    $s = "SELECT * FROM userReg WHERE name = '$name'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        echo "<script>alert('Username already exists'); window.location='login.php';</script>";
    } else {
        /* Thêm bản ghi mới vào bảng userReg */
        $reg = "INSERT INTO userReg (name, password, student_id, dob, country) 
                VALUES ('$name', '$pass', '$student_id', '$dob', '$country')";
        mysqli_query($con, $reg);
        echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
    }
}

/* --- Nếu người dùng nhấn nút Đăng nhập --- */
if (isset($_POST['login'])) {

    /* Lấy dữ liệu từ form đăng nhập */
    $name = $_POST['user'];
    $pass = $_POST['password'];

    /* Kiểm tra thông tin trong database */
    $s = "SELECT * FROM userReg WHERE name = '$name' && password = '$pass'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $_SESSION['username'] = $name;
        header('location:home.php');
    } else {
        echo "<script>alert('Invalid username or password'); window.location='login.php';</script>";
    }
}
?>