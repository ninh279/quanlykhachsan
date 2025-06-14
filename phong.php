<?php
session_start();

// Cấu hình kết nối database
$servername = "localhost";
$username = "root"; // Thay đổi theo cấu hình của bạn
$password = "";     // Thay đổi theo cấu hình của bạn
$dbname = "qlkhachsan"; // Thay đổi tên database của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập charset UTF-8
$conn->set_charset("utf8mb4");

// Truy vấn dữ liệu từ bảng phong
$sql = "SELECT ROOMID, LOAI_PHONG, MOTA, GIA, TRANG_THAI FROM phong ORDER BY ROOMID";
$result = $conn->query($sql);

// Mảng hình ảnh mẫu cho các loại phòng
$room_images = [
    'Phòng Đơn' => 'data:image/jpeg;base64,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',
    'Phòng Đôi' => 'https://i.pinimg.com/736x/81/91/5d/81915d4f2260ea5c5f8a2022eb239e63.jpg',
    'Phòng VIP' => 'https://noithatmanhhe.vn/wp-content/uploads/2024/11/Phong_ngu_phong_cach_chau_au-25.webp',
    'Phòng Gia Đình' => 'https://eholiday.vn/wp-content/uploads/2023/05/Khach-san-Muong-Thanh-Luxury-Ha-Long-Centre-Phong-Deluxe-Triple-Ocean-View.jpg',
    'Phòng Sang Trọng' => 'https://i.pinimg.com/736x/0c/df/0e/0cdf0efbd9dea775b285b1129158aea8.jpg',
    'Phòng Tổng Thống' => 'https://2sao.vietnamnetjsc.vn/images/2024/04/25/15/49/tai-sao-goi-la-phong-tong-thong-co-gi-ben-trong-do-3-12120688.jpg',
];

// Hàm lấy hình ảnh theo loại phòng
function getRoomImage($loai_phong, $room_images) {
    return isset($room_images[$loai_phong]) ? $room_images[$loai_phong] : 'https://i.pinimg.com/736x/4f/b4/15/4fb415a8a195aaa4d48dd4886513da0e.jpg';
}

// Hàm format giá tiền
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . ' VND/đêm';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Danh Sách Phòng - Maison de Luxe</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <style>
 /* Reset cơ bản */
*, *::before, *::after {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: 'Playfair Display', sans-serif;
  background-color: rgba(244, 244, 244, 0);
  color: #ffffff;
  font-size: 18px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Header & Nav */
header {
  background-color: rgba(0, 0, 0, 0.78);
  padding: 15px 20px;
  position: sticky;
  top: 0;
  z-index: 1000;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo-container img {
  height: 50px;
  margin-right: 20px;
}

.logo-container span {
  font-weight: 700;
  font-size: 1.5rem;
  letter-spacing: 1.5px;
}

nav a {
  color: white;
  text-decoration: none;
  margin-left: 20px;
  font-weight: 600;
  font-size: 16px;
  transition: background-color 0.4s ease;
}

nav a:hover, nav a:focus {
  background-color: rgba(255, 255, 255, 0.69);
  outline: none;
  padding: 15px 20px;
  border-radius: 5px;
}

/* Container */
.container {
  position: relative;
  width: 100%;
  margin: 5px 0;
  padding: 20px;
  display: flex;
  flex-direction: column;
  min-height: calc(200vh - 400px);
  background-image: url('https://i.pinimg.com/736x/20/2c/a2/202ca2635a43c4a2e90450ddc0cb102f.jpg');
  background-size: cover;
  background-position: center;
  color: white;
  border: 0.5px solid currentcolor;
}

.container:before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 1;
}

.container > * {
  position: relative;
  z-index: 2;
}

h1, h2 {
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 20px;
  line-height: 1.2;
  text-align: center;
}

h1 {
  font-size: 48px;
}

h2 {
  font-size: 36px;
}

p.subtitle {
  max-width: 800px;
  margin: 0 auto 20px auto;
  text-align: center;
  color: #ffffff;
  font-size: 18px;
  line-height: 1.6;
  user-select: none;
}

/* Room list - grid */
.room-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  padding: 20px;
  justify-content: center;
  max-width: 1200px;
  margin: 0 auto;
}

/* Card phòng */
.room-card {
  background: rgba(255, 255, 255, 0.82);
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
  overflow: hidden;
  width: 100%;
  height: 420px;
  display: flex;
  flex-direction: column;
  transition: none;
  user-select: none;
}

.room-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
}

.card-content {
  padding: 15px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background: rgba(0, 0, 0, 0.7);
  border-radius: 5px;
  color: white;
}

.room-title {
  font-size: 20px;
  font-weight: 700;
  color: #ffffff;
  margin: 0 0 10px;
}

.room-description {
  flex-grow: 1;
  color: #ffffff;
  font-size: 14px;
  line-height: 1.6;
  margin: 0 0 10px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}

.room-price {
  font-weight: 700;
  font-size: 14px;
  color: #ffffff;
  margin: 0 0 10px;
  user-select: text;
}

.room-status {
  font-weight: 700;
  font-size: 14px;
  margin: 0 0 10px;
  user-select: none;
}

.status-available {
  color: gold;
}

.status-booked {
  color: #ef4444;
}

/* Nút đặt phòng */
.btn-book {
  background-color: rgba(255, 255, 255, 0.74);
  color: #000000;
  border: none;
  padding: 12px 20px;
  border-radius: 5px;
  font-weight: 700;
  font-size: 16px;
  cursor: pointer;
  user-select: none;
  text-decoration: none;
  text-align: center;
  transition: background-color 0.3s ease, transform 0.3s ease;
  margin-top: auto;
}

.btn-book:hover, .btn-book:focus {
  background-color: rgba(250, 250, 250, 0.75);
  transform: scale(1.05);
  box-shadow: 0 4px 15px rgba(255, 255, 255, 0.5);
  outline: none;
}

.btn-book.disabled {
  background-color: #888888;
  cursor: not-allowed;
  opacity: 0.6;
  transform: none;
  box-shadow: none;
}

.btn-book.disabled:hover {
  background-color: #888888;
  transform: none;
  box-shadow: none;
}

/* Error message */
.error-message {
  color: #dc2626;
  padding: 20px;
  border-radius: 8px;
  margin: 20px 0;
  text-align: center;
  font-size: 18px;
  line-height: 1.6;
}

.no-rooms {
  text-align: center;
  color: #ffffff;
  font-size: 18px;
  margin: 20px 0;
}

/* Footer */
.footer {
  background-color: #000000;
  text-align: center;
  padding: 20px;
  width: 100%;
  color: #ffffff;
  font-size: 18px;
}

/* Responsive */
@media (max-width: 768px) {
  .room-list {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 10px;
  }

  .room-card {
    width: 100%;
    height: auto;
    min-height: 400px;
  }

  h1 {
    font-size: 36px;
  }

  h2 {
    font-size: 28px;
  }

  .btn-book {
    font-size: 14px;
    padding: 10px 15px;
  }
}

@media (max-width: 480px) {
  .room-list {
    grid-template-columns: 1fr;
    gap: 15px;
  }

  .room-card {
    width: 100%;
    height: auto;
    min-height: 400px;
  }

  h1 {
    font-size: 30px;
  }

  h2 {
    font-size: 24px;
  }

  .room-title {
    font-size: 18px;
  }

  .room-description {
    font-size: 14px;
  }

  .room-price {
    font-size: 14px;
  }

  .room-status {
    font-size: 14px;
  }
}
  </style>
</head>
<body>
  <header>
    <div class="logo-container">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCa4rtF1uHKIwm7hVsWIyWzgyavMKcK120qSXVmcasNrp4cN22" alt="Logo" />
      <span>Maison de Luxe</span>
    </div>
    <nav>
      <a href="trangchu.php">Trang Chủ</a>
      <a href="dichvu.php">Dịch Vụ</a>
      <a href="uudai.php">Ưu Đãi</a>
      <a href="datphong.php">Liên Hệ Đặt Phòng</a>
    </nav>
  </header>

  <main class="container">
    <h1>Danh Sách Phòng</h1>
    <p class="subtitle">Khám phá các phòng sang trọng với nhiều tiện nghi hiện đại và dịch vụ đẳng cấp tại Maison de Luxe.</p>

    <div class="room-list">
      <?php
      if ($result && $result->num_rows > 0) {
          // Hiển thị dữ liệu từng phòng
          while($row = $result->fetch_assoc()) {
              $roomId = $row["ROOMID"];
              $loaiPhong = $row["LOAI_PHONG"];
              $moTa = $row["MOTA"];
              $gia = $row["GIA"];
              $trangThai = $row["TRANG_THAI"];
              
              // Xác định class cho trạng thái
              $statusClass = ($trangThai == 'còn trống') ? 'status-available' : 'status-booked';
              $statusText = ($trangThai == 'còn trống') ? 'Còn trống' : 'Đã đặt';
              
              // Xác định trạng thái nút
              $buttonDisabled = ($trangThai == 'đã đặt') ? true : false;
              $buttonClass = $buttonDisabled ? 'btn-book disabled' : 'btn-book';
              $buttonText = $buttonDisabled ? 'Đã Đặt' : 'Đặt Ngay';
              
              echo '<article class="room-card" tabindex="0" aria-label="' . htmlspecialchars($loaiPhong) . '">';
              echo '<img src="' . getRoomImage($loaiPhong, $room_images) . '" alt="' . htmlspecialchars($loaiPhong) . '" class="room-image" />';
              echo '<div class="card-content">';
              echo '<h2 class="room-title">' . htmlspecialchars($loaiPhong) . '</h2>';
              echo '<p class="room-description">' . htmlspecialchars($moTa) . '</p>';
              echo '<p class="room-price">Giá: ' . formatPrice($gia) . '</p>';
              echo '<p class="room-status ' . $statusClass . '">' . $statusText . '</p>';
              
              if ($buttonDisabled) {
                  echo '<span class="' . $buttonClass . '" aria-disabled="true" tabindex="-1">' . $buttonText . '</span>';
              } else {
                  echo '<a href="datphong.php?room_id=' . $roomId . '" class="' . $buttonClass . '" role="button">' . $buttonText . '</a>';
              }
              
              echo '</div>';
              echo '</article>';
          }
      } else {
          echo '<div class="no-rooms">Hiện tại không có phòng nào trong hệ thống.</div>';
      }
      ?>
    </div>
  </main>

  <div class="footer">
    <p>© 2025 Maison de Luxe. Mọi quyền được bảo lưu.</p>
  </div>

<?php
// Đóng kết nối
$conn->close();
?>
</body>
</html>