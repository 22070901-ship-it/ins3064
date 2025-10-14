<?php
include("db_connect.php");

if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Kiểm tra username đã tồn tại chưa
    $check_user = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($link, $check_user);

    if (mysqli_num_rows($result) > 0) {
        echo "Username already exists!";
    } else {
        $query = "INSERT INTO users (fullname, username, password) VALUES ('$fullname', '$username', '$password')";
        if (mysqli_query($link, $query)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="post">
        <label>Full name</label><br>
        <input type="text" name="fullname" required><br>

        <label>Username</label><br>
        <input type="text" name="username" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
