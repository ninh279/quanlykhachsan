<?php
require_once 'dangky.php';
// Kết nối đến cơ sở dữ liệu
try {
    $pdo = new PDO('mysql:host=localhost;dbname=qlkhachsan', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . $e->getMessage());
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'] ?? '';
    $ngay = $_POST['ngay'] ?? '';
    $thang = $_POST['thang'] ?? '';
    $nam = $_POST['nam'] ?? '';
    $gioitinh = $_POST['gioitinh'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $username = $_POST['username'] ?? '';
    $matkhau = $_POST['matkhau'] ?? '';
    $cccd = $_POST['cccd'] ?? '';

    // Kiểm tra định dạng SDT và CCCD
    if (!preg_match('/^[0-9]{10}$/', $sdt)) {
        $error = 'Số điện thoại phải là 10 chữ số.';
    } elseif (!preg_match('/^[0-9]{12}$/', $cccd)) {
        $error = 'CCCD phải là 12 chữ số.';
    } elseif (!checkdate($thang, $ngay, $nam)) {
        $error = 'Ngày sinh không hợp lệ.';
    } else {
        try {
            // Kiểm tra username, SDT, CCCD đã tồn tại
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM USERS WHERE USERNAME = ? OR SDT = ? OR CCCD = ?");
            $stmt->execute([$username, $sdt, $cccd]);
            if ($stmt->fetchColumn() > 0) {
                $error = 'Tên đăng nhập, số điện thoại hoặc CCCD đã được sử dụng.';
            } else {
                // Mã hóa mật khẩu
                $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);

                // Kết hợp ngày sinh thành định dạng DATE
                $ngaysinh = sprintf('%04d-%02d-%02d', $nam, $thang, $ngay);

                // Chèn dữ liệu vào bảng USERS
                $stmt = $pdo->prepare("INSERT INTO USERS (HOTEN, SDT, USERNAME, MATKHAU, CCCD, NGAYSINH, GIOITINH) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$hoten, $sdt, $username, $hashed_password, $cccd, $ngaysinh, $gioitinh]);

                $success = 'Đăng ký thành công! Bạn sẽ được chuyển hướng sau 3 giây.';
                header('Refresh: 3; URL=dangnhap.php');
            }
        } catch (PDOException $e) {
            $error = 'Lỗi: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Maison de Luxe</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Playfair Display', serif;
            background: url('https://scontent.fsgn2-9.fna.fbcdn.net/v/t39.30808-6/492097774_1105792444908486_6261141051732490251_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=127cfc&_nc_ohc=Zznqs9ZmIZQQ7kNvwHuGGmH&_nc_oc=AdkTOWwnDte0rv3aPo-LbBeWZJrwLtOcST5PrOW9V31qiXKcWoFhADbIWrARyEvOSNMi6s8DwhSEnIT27f-HP4Wu&_nc_zt=23&_nc_ht=scontent.fsgn2-9.fna&_nc_gid=4a0MWSiZ8lpoRmoD_BhZPw&oh=00_AfPEsx6h7I5y0Enu9oVxM9NDEsKr6D4Q7lEk8raeNtC5pw&oe=6847884F') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: opacity 0.4s ease;
        }

        .password-wrapper .eye-icon:hover {
            color: #fff;
        }

        .register-box {
            background-color: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 30px 35px;
            border-radius: 20px;
            width: 320px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }

        .register-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            background-color: #2d2d2d;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-family: 'Playfair Display', serif;
        }

        select option {
            color: #000;
        }

        .gender-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .gender-group label {
            flex: 1;
            margin: 0 3px;
            padding: 8px;
            background-color: #2d2d2d;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .gender-group input {
            margin-right: 6px;
        }

        button {
            background-color: #000;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.4s ease;
        }

        button:hover {
            background-color: #222;
        }

        .link {
            margin-top: 14px;
            font-size: 13px;
        }

        .link a {
            color: #ccc;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .error, .success {
            font-size: 13px;
            text-align: center;
            margin-bottom: 15px;
        }

        .error {
            color: #ff4d4d;
        }

        .success {
            color: #4dff4d;
        }
    </style>
    <script>
    function togglePasswordVisibility() {
      const passwordInput = document.querySelector('input[name="matkhau"]');
      const eyeIcon = document.querySelector('.eye-icon i');
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }

    function goToLogin() {
      document.body.style.opacity = 0;
      setTimeout(function() {
        window.location.href = "dangky.php";
      }, 400); // Đồng bộ với transition 0.4s
    }
  </script>
</head>
<body>
    <div class="register-box">
        <h2>Maison de Luxe</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="hoten" placeholder="Họ và tên" required>
            <div style="text-align: left; font-size: 13px; margin-bottom: 6px;"></div>
            <div style="display: flex; gap: 5px;">
                <select name="ngay" required>
                    <option value="">Ngày</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="thang" required>
                    <option value="">Tháng</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="nam" required>
                    <option value="">Năm</option>
                    <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="gender-group">
                <label><input type="radio" name="gioitinh" value="Nam" required> Nam</label>
                <label><input type="radio" name="gioitinh" value="Nữ"> Nữ</label>
                <label><input type="radio" name="gioitinh" value="Khác"> Khác</label>
            </div>
            <input type="text" name="sdt" placeholder="Số điện thoại" required>
            <input type="text" name="cccd" placeholder="CCCD" required>
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="matkhau" placeholder="Mật khẩu" required>
            <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></span>
            <button type="submit">Đăng ký</button>
            <div class="link">
                <a href="javascript:void(0)" class="register" onclick="goToLogin()">Đã có tài khoản? Đăng nhập</a>
            </div>
        </form>
    </div>
    <script>
    function goToLogin() {
      document.body.style.transition = "opacity 0.4s ease";
      document.body.style.opacity = 0;

      setTimeout(function() {
        window.location.href = "dangnhap.php"; // Đường dẫn đến trang đăng nhập
      }, 400);
    }
  </script>
</body>
</html>