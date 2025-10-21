<?php
session_start();
require_once 'config.php'; // Kết nối tới database user_auth

$username_email = $password = '';
$login_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_email = trim($_POST['username_email']);
    $password = trim($_POST['password']);

    if (empty($username_email) || empty($password)) {
        $login_err = 'Vui lòng điền đầy đủ tên đăng nhập/email và mật khẩu.';
    } else {
        // Kiểm tra user theo username hoặc email
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $username_email, $username_email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                // Kiểm tra mật khẩu
                if (password_verify($password, $user['password'])) {
                    // Lưu session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];

                    // Chuyển đến trang chính
                    header("Location: home.php");
                    exit;
                } else {
                    $login_err = 'Mật khẩu không chính xác.';
                }
            } else {
                $login_err = 'Không tìm thấy tài khoản.';
            }
            mysqli_stmt_close($stmt);
        } else {
            $login_err = 'Lỗi truy vấn dữ liệu.';
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        .wrapper {
            width: 360px;
            margin: 80px auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        .input-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Đăng Nhập</h2>
        <?php if (!empty($login_err)) echo '<p class="error">' . htmlspecialchars($login_err) . '</p>'; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="input-group">
                <label>Tên người dùng hoặc Email</label>
                <input type="text" name="username_email" value="<?php echo htmlspecialchars($username_email); ?>">
            </div>
            <div class="input-group">
                <label>Mật khẩu</label>
                <input type="password" name="password">
            </div>
            <button type="submit">Đăng Nhập</button>
            <p>Chưa có tài khoản? <a href="registration.php">Đăng ký tại đây</a></p>
        </form>
    </div>
</body>
</html>