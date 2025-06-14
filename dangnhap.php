<?php
// Kiểm tra và bắt đầu session an toàn
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Khởi tạo biến thông báo
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Kết nối SQL
  $ketnoi = new mysqli("localhost", "root", "", "qlkhachsan");
  if ($ketnoi->connect_error) {
    die("Kết nối thất bại: " . $ketnoi->connect_error);
  }

  $username = $_POST['username'] ?? '';
  $matkhau = $_POST['matkhau'] ?? '';

  if (empty($username) || empty($matkhau)) {
    $message = "<span style='color:red;'>Vui lòng điền đầy đủ thông tin!</span>";
  } else {
    // Chuẩn bị câu lệnh SQL
    $sql = "SELECT USERID, USERNAME, MATKHAU FROM USERS WHERE USERNAME = ?";
    $stmt = $ketnoi->prepare($sql);
    if ($stmt === false) {
      $message = "<span style='color:red;'>Lỗi chuẩn bị câu lệnh: " . $ketnoi->error . "</span>";
    } else {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();

      // Kiểm tra xem có bản ghi nào khớp không
      if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if (password_verify($matkhau, $user['MATKHAU'])) {
          // Lưu thông tin vào session
          $_SESSION['USERID'] = $user['USERID'];
          $_SESSION['username'] = $user['USERNAME'];
          $message = "<span style='color:green;'>Đăng nhập thành công!</span>";
          // Chuyển hướng đến trang chính
          header("Location: trangchu.php");
          exit;
        } else {
          $message = "<span style='color:red;'>Sai mật khẩu!</span>";
        }
      } else {
        $message = "<span style='color:red;'>Tài khoản không tồn tại!</span>";
      }
      $stmt->close();
    }
  }
  $ketnoi->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Maison de Luxe - Đăng nhập</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body, html {
      height: 100%;
      font-family: 'Playfair Display', serif;
      transition: opacity 0.4s ease;
    }

    .background {
      background-image: url('https://chatgpt.com/backend-api/public_content/enc/eyJpZCI6Im1fNjgzZjFkYTA3ZDUwODE5MWI2MjExNWU4ZTFjNzQxZjk6ZmlsZV8wMDAwMDAwMDUwNDg2MWY3YTUwM2FlNDc5NjliOTY4MyIsInRzIjoiNDg1ODI1IiwicCI6InB5aSIsInNpZyI6IjVjNjUxYjc2MjRlMWZiNWM4MDRmM2YwNzY2YzEzYmQzZTFkYTU5OWVkZGRjMzkxYzAyOWMyODNkNmY1ZTFhZjAiLCJ2IjoiMCIsImdpem1vX2lkIjpudWxsfQ==');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background: rgba(0, 0, 0, 0.65);
      padding: 40px;
      border-radius: 20px;
      width: 320px;
      color: #fff;
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      backdrop-filter: blur(8px);
    }

    .login-card h1 {
      font-size: 26px;
      margin-bottom: 25px;
      text-align: center;
      font-weight: 500;
    }

    .login-card input[type="text"],
    .login-card input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: none;
      border-radius: 10px;
      background: #2c2c2c;
      color: #fff;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper .eye-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      cursor: pointer;
      color: #aaa;
    }

    .password-wrapper .eye-icon:hover {
      color: #fff;
    }

    .remember-me {
      display: flex;
      align-items: center;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .remember-me input {
      margin-right: 8px;
    }

    .login-card button {
      width: 100%;
      padding: 12px;
      background-color: #000;
      border: none;
      color: #fff;
      border-radius: 10px;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.4s ease;
    }

    .login-card button:hover {
      background-color: #444;
    }

    .login-card .forgot {
      display: block;
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
      color: #ccc;
      text-decoration: none;
    }

    .login-card .forgot:hover {
      color: #fff;
    }

    .register {
      display: block;
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
      color: #ccc;
      text-decoration: none;
    }

    .register:hover {
      color: #fff;
    }

    .error {
      color: #ff4d4d;
      font-size: 13px;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
  <form id="loginForm" method="POST" action="">
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

  document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
      event.preventDefault(); // Ngăn chặn submit mặc định

      // Lấy dữ liệu từ form
      const formData = new FormData(loginForm);

      // Gửi dữ liệu bằng AJAX để xử lý đăng nhập
      fetch('', {  // Sử dụng URL hiện tại để gửi dữ liệu
        method: 'POST',
        body: formData
      })
      .then(response => {
        // Kiểm tra nếu response là HTML (chứa thông báo lỗi hoặc thành công)
        if (response.headers.get('content-type').includes('text/html')) {
          return response.text().then(html => {
            // Tạo một DOMParser để parse HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Tìm phần tử chứa thông báo
            const messageElement = doc.querySelector('.error'); // Hoặc selector phù hợp

            // Nếu tìm thấy, hiển thị thông báo
            if (messageElement) {
              document.querySelector('.error').innerHTML = messageElement.innerHTML;
            } else {
              // Nếu không có lỗi, thực hiện chuyển trang
              document.body.style.opacity = 0;
              setTimeout(function() {
                window.location.href = "trangchu.php";
              }, 400); // Thời gian chờ phải khớp với thời gian transition
            }
          });
        } else {
          // Xử lý response không phải HTML (ví dụ: JSON)
          console.log('Response không phải là HTML', response);
        }
      })
      .catch(error => {
        console.error('Lỗi:', error);
      });
    });
  });
</script>

</head>
<body>
  <div class="background">
    <div class="login-card">
      <h1>Maison de Luxe</h1>
      <?php if ($message): ?>
        <p class="error"><?php echo $message; ?></p>
      <?php endif; ?>
      <form method="POST" action="">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <div class="password-wrapper">
          <input type="password" name="matkhau" placeholder="Mật khẩu" required>
          <span class="eye-icon" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></span>
        </div>
        <div class="remember-me">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Ghi nhớ tôi</label>
        </div>
        <button type="submit">Đăng Nhập</button>
        <a href="#" class="forgot">Quên mật khẩu?</a>
        <a href="javascript:void(0)" class="register" onclick="goToLogin()">Chưa có tài khoản? Đăng ký</a>
      </form>
    </div>
  </div>
</body>
</html>