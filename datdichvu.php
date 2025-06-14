<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlkhachsan"; // Thay bằng tên database của bạn

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Lấy dữ liệu cho dropdown
$users = $conn->query("SELECT USERID, HOTEN, SDT FROM USERS")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $conn->query("SELECT ROOMID, LOAI_PHONG, GIA FROM phong WHERE TRANG_THAI = 'còn trống'")->fetchAll(PDO::FETCH_ASSOC);
$services = $conn->query("SELECT SERVICEID, TEN_DICH_VU, GIA FROM dichvu")->fetchAll(PDO::FETCH_ASSOC);

// Xử lý form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'] ?? '';
    $hoten = $_POST['hoten'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $roomId = $_POST['roomId'];
    $serviceId = $_POST['serviceId'];

    try {
        // Nếu người dùng nhập thông tin mới (HOTEN và SDT)
        if (!empty($hoten) && !empty($sdt)) {
            // Kiểm tra định dạng SDT (10 chữ số)
            if (!preg_match('/^[0-9]{10}$/', $sdt)) {
                throw new Exception("Số điện thoại phải có 10 chữ số.");
            }

            // Kiểm tra SDT đã tồn tại
            $stmt = $conn->prepare("SELECT USERID FROM USERS WHERE SDT = :sdt");
            $stmt->bindParam(':sdt', $sdt);
            $stmt->execute();
            if ($stmt->fetch()) {
                throw new Exception("Số điện thoại đã được đăng ký.");
            }

            // Tạo thông tin người dùng mới (giả định các trường khác)
            $username = "user_" . time(); // Tạm thời tạo username duy nhất
            $matkhau = password_hash("default123", PASSWORD_DEFAULT); // Mật khẩu mặc định
            $cccd = "000000000000"; // Giá trị giả định, có thể yêu cầu nhập thêm
            $stmt = $conn->prepare("INSERT INTO USERS (HOTEN, SDT, USERNAME, MATKHAU, CCCD) VALUES (:hoten, :sdt, :username, :matkhau, :cccd)");
            $stmt->bindParam(':hoten', $hoten);
            $stmt->bindParam(':sdt', $sdt);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':matkhau', $matkhau);
            $stmt->bindParam(':cccd', $cccd);
            $stmt->execute();

            // Lấy USERID của người dùng vừa thêm
            $userId = $conn->lastInsertId();
        } elseif (empty($userId)) {
            throw new Exception("Vui lòng chọn người dùng hoặc nhập thông tin mới.");
        }

        // Đăng ký dịch vụ
        $stmt = $conn->prepare("INSERT INTO SERVICE_REGISTRATION (USERID, ROOMID, SERVICEID) VALUES (:userId, :roomId, :serviceId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':roomId', $roomId);
        $stmt->bindParam(':serviceId', $serviceId);
        $stmt->execute();
        $success = "Đăng ký dịch vụ thành công!";
    } catch(Exception $e) {
        $error = "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Dịch Vụ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #1f2937;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .hidden {
            display: none;
        }
        .md\:flex {
            display: flex;
        }
        .space-x-8 > * + * {
            margin-left: 2rem;
        }
        .nav-link {
            color: #d1d5db;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-link:hover {
            color: #ffffff;
        }
        .nav-link.active {
            color: #3b82f6;
            font-weight: 700;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin: 2rem auto;
        }
        h2 {
            text-align: center;
            color: #2563eb;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 5px;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 1rem;
        }
        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #1d4ed8;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        @media (min-width: 768px) {
            .hidden {
                display: block;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">

        </div>
    </nav>

    <div class="container">
        <h2>Đăng Ký Dịch Vụ</h2>
        <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="userId">Chọn người dùng </label>
                <select name="userId" id="userId">
                    <option value="">-- Chọn người dùng --</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user['USERID']; ?>">
                            <?php echo htmlspecialchars($user['HOTEN']) . " (" . $user['SDT'] . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hoten">Họ và tên </label>
                <input type="text" name="hoten" id="hoten" placeholder="Nhập họ và tên">
            </div>
            <div class="form-group">
                <label for="sdt">Số điện thoại </label>
                <input type="text" name="sdt" id="sdt" placeholder="Nhập số điện thoại (10 số)">
            </div>
            <div class="form-group">
                <label for="roomId">Phòng</label>
                <select name="roomId" id="roomId" required>
                    <option value="">Chọn phòng</option>
                    <?php foreach ($rooms as $room) { ?>
                        <option value="<?php echo $room['ROOMID']; ?>">
                            <?php echo htmlspecialchars($room['LOAI_PHONG']) . " - " . number_format($room['GIA'], 0, ',', '.') . " VNĐ"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="serviceId">Dịch vụ</label>
                <select name="serviceId" id="serviceId" required>
                    <option value="">Chọn dịch vụ</option>
                    <?php foreach ($services as $service) { ?>
                        <option value="<?php echo $service['SERVICEID']; ?>">
                            <?php echo htmlspecialchars($service['TEN_DICH_VU']) . " - " . number_format($service['GIA'], 0, ',', '.') . " VNĐ"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit">Đăng Ký</button>
        </form>
    </div>
</body>
</html>