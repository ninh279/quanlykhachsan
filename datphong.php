<?php 
// Enable error reporting for debugging 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 

// Kết nối cơ sở dữ liệu 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "qlkhachsan"; 

try { 
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
   $conn->exec("SET NAMES 'utf8mb4'"); 
} catch(PDOException $e) { 
   die("Kết nối cơ sở dữ liệu thất bại: " . htmlspecialchars($e->getMessage())); 
} 

// Lấy danh sách người dùng 
try { 
   $stmt_users = $conn->prepare("SELECT USERID, HOTEN FROM USERS"); 
   $stmt_users->execute(); 
   $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC); 
   if (empty($users)) { 
       $error = "Không có người dùng nào được tìm thấy."; 
       error_log("No users found in USERS table."); 
   } 
} catch(PDOException $e) { 
   $error = "Lỗi khi lấy danh sách người dùng: " . htmlspecialchars($e->getMessage()); 
   error_log("User query error: " . $e->getMessage()); 
} 

// Lấy danh sách phòng 
try { 
   // First attempt: Fetch all rooms to ensure data retrieval 
   $stmt_rooms = $conn->prepare("SELECT ROOMID, TENPHONG FROM phong"); 
   // Alternative: Fetch only available rooms (uncomment to use) 
    $stmt_rooms = $conn->prepare("SELECT ROOMID, TENPHONG FROM phong WHERE TRANG_THAI = 'còn trống'"); 
   // If TENPHONG is LOAI_PHONG, use: 
    $stmt_rooms = $conn->prepare("SELECT ROOMID, LOAI_PHONG AS TENPHONG FROM phong"); 
   $stmt_rooms->execute(); 
   $rooms = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC); 
   if (empty($rooms)) { 
       $error = "Không có phòng nào được tìm thấy trong cơ sở dữ liệu."; 
       error_log("No rooms found in phong table. Query: SELECT ROOMID, TENPHONG FROM phong"); 
   } else { 
       error_log("Found " . count($rooms) . " rooms in phong table."); 
   } 
} catch(PDOException $e) { 
   $error = "Lỗi khi lấy danh sách phòng: " . htmlspecialchars($e->getMessage()); 
   error_log("Room query error: " . $e->getMessage()); 
} 

// Xử lý form khi submit 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
   // Use isset() to prevent undefined key errors and fix HO_TEN to ho_ten 
   $userid = isset($_POST['userid']) ? $_POST['userid'] : ''; 
   $roomid = isset($_POST['roomid']) ? $_POST['roomid'] : ''; 
   $ngay_nhan = isset($_POST['ngay_nhan']) ? $_POST['ngay_nhan'] : ''; 
   $ngay_tra = isset($_POST['ngay_tra']) ? $_POST['ngay_tra'] : ''; 
   $ho_ten = isset($_POST['ho_ten']) ? $_POST['ho_ten'] : ''; // Fixed: Changed 'HO_TEN' to 'ho_ten' 
   $so_dien_thoai = isset($_POST['so_dien_thoai']) ? $_POST['so_dien_thoai'] : ''; 
   $email = isset($_POST['email']) ? $_POST['email'] : ''; 

   // Kiểm tra dữ liệu 
   if (empty($userid) || empty($roomid) || empty($ngay_nhan) || empty($ngay_tra) || empty($ho_ten) || empty($so_dien_thoai) || empty($email)) { 
       $error = "Vui lòng điền đầy đủ thông tin!"; 
   } elseif (strtotime($ngay_tra) <= strtotime($ngay_nhan)) { 
       $error = "Ngày trả phòng phải sau ngày nhận phòng!"; 
   } else { 
       try { 
           // Bắt đầu transaction 
           $conn->beginTransaction(); 

           // Cập nhật trạng thái phòng thành 'đã đặt' 
           $update_room = $conn->prepare("UPDATE phong SET TRANG_THAI = 'đã đặt' WHERE ROOMID = :roomid"); 
           $update_room->bindParam(':roomid', $roomid); 
           $update_room->execute(); 

           // Thêm bản ghi vào bảng datphong 
           $sql = "INSERT INTO datphong (USERID, ROOMID, NGAY_NHAN, NGAY_TRA, HO_TEN, SO_DIEN_THOAI, EMAIL) 
                   VALUES (:userid, :roomid, :ngay_nhan, :ngay_tra, :ho_ten, :so_dien_thoai, :email)"; 
           $stmt = $conn->prepare($sql); 
           $stmt->bindParam(':userid', $userid); 
           $stmt->bindParam(':roomid', $roomid); 
           $stmt->bindParam(':ngay_nhan', $ngay_nhan); 
           $stmt->bindParam(':ngay_tra', $ngay_tra); 
           $stmt->bindParam(':ho_ten', $ho_ten); 
           $stmt->bindParam(':so_dien_thoai', $so_dien_thoai); 
           $stmt->bindParam(':email', $email); 
            
           if ($stmt->execute()) { 
               $conn->commit(); 
               $success = "Đặt phòng thành công!"; 
           } else { 
               $conn->rollBack(); 
               $error = "Lỗi khi đặt phòng!"; 
           } 
       } catch(PDOException $e) { 
           $conn->rollBack(); 
           $error = "Lỗi: " . htmlspecialchars($e->getMessage()); 
           error_log("Booking error: " . $e->getMessage()); 
       } 
   } 
} 
?> 

<!DOCTYPE html> 
<html lang="vi"> 
<head> 
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <title>Đặt Phòng</title> 
   <script src="https://cdn.tailwindcss.com"></script> 
</head> 
<body class="bg-gray-100 font-sans"> 
   <!-- Navigation Menu --> 
   <nav class="bg-blue-600 text-white p-4 shadow-md"> 
       <div class="container mx-auto flex justify-between items-center"> 
           <h1 class="text-2xl font-bold">Khách Sạn XYZ</h1> 
           <div class="space-x-4"> 
                <a href="trangchu.php" class="hover:bg-blue-700 px-3 py-2 rounded">Trang Chủ </a> 
               <a href="phong.php" class="hover:bg-blue-700 px-3 py-2 rounded">Hạng Phòng</a> 
               <a href="dichvu.php" class="hover:bg-blue-700 px-3 py-2 rounded">Dịch Vụ</a> 
               <a href="uudai.php" class="hover:bg-blue-700 px-3 py-2 rounded">Ưu Đãi</a> 
                
           </div> 
       </div> 
   </nav> 

   <!-- Main Content --> 
   <div class="container mx-auto mt-8 max-w-lg p-6 bg-white rounded-lg shadow-lg"> 
       <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Form Đặt Phòng</h2> 
        
       <?php if (isset($error)) { echo "<p class='text-red-500 text-center mb-4'>" . htmlspecialchars($error) . "</p>"; } ?> 
       <?php if (isset($success)) { echo "<p class='text-green-500 text-center mb-4'>" . htmlspecialchars($success) . "</p>"; } ?> 

       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4"> 
           <div> 
               <label for="userid" class="block text-sm font-medium text-gray-700">Người dùng:</label> 
               <select id="userid" name="userid" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
                   <option value="">Chọn người dùng</option> 
                   <?php foreach ($users as $user): ?> 
                       <option value="<?php echo htmlspecialchars($user['USERID']); ?>"><?php echo htmlspecialchars($user['HOTEN']); ?></option> 
                   <?php endforeach; ?> 
               </select> 
           </div> 
           <div> 
               <label for="roomid" class="block text-sm font-medium text-gray-700">Phòng:</label> 
               <select id="roomid" name="roomid" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
                   <option value="">Chọn phòng</option> 
                   <?php foreach ($rooms as $room): ?> 
                       <option value="<?php echo htmlspecialchars($room['ROOMID']); ?>"><?php echo htmlspecialchars($room['TENPHONG']); ?></option> 
                   <?php endforeach; ?> 
               </select> 
           </div> 
           <div> 
               <label for="ngay_nhan" class="block text-sm font-medium text-gray-700">Ngày nhận phòng:</label> 
               <input type="date" id="ngay_nhan" name="ngay_nhan" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
           </div> 
           <div> 
               <label for="ngay_tra" class="block text-sm font-medium text-gray-700">Ngày trả phòng:</label> 
               <input type="date" id="ngay_tra" name="ngay_tra" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
           </div> 
           <div> 
               <label for="ho_ten" class="block text-sm font-medium text-gray-700">Họ và tên:</label> 
               <input type="text" id="ho_ten" name="ho_ten" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
           </div> 
           <div> 
               <label for="so_dien_thoai" class="block text-sm font-medium text-gray-700">Số điện thoại:</label> 
               <input type="text" id="so_dien_thoai" name="so_dien_thoai" pattern="[0-9]{10}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
           </div> 
           <div> 
               <label for="email" class="block text-sm font-medium text-gray-700">Email:</label> 
               <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"> 
           </div> 
           <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 transition duration-200">Đặt phòng</button> 
       </form> 
   </div> 
</body> 
</html>
