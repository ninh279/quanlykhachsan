<?php 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "qlkhachsan"; 

try { 
   $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password); 
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
   $stmt = $conn->prepare("SELECT * FROM dichvu"); 
   $stmt->execute(); 
   $services = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch(PDOException $e) { 
   echo "Connection failed: " . $e->getMessage(); 
   exit; 
} 

// Array mapping SERVICEID to image URLs (images are not stored in SQL) 
$serviceImages = [ 
   1 => "https://i.pinimg.com/736x/e8/8b/23/e88b2398c7d98f9f28c52aeb9144d21a.jpg", // Buffet Breakfast 
   2 => "https://i.pinimg.com/736x/4e/80/e5/4e80e5b522c8ce99e489e10b0ce0e107.jpg", // Airport Transfer 
   3 => "https://i.pinimg.com/736x/52/bb/04/52bb04e38b5ff859d8a85342dc8c73ec.jpg", // Spa 
   4 => "https://i.pinimg.com/736x/50/0c/15/500c1501321fed2eee2fa99c37c21e7d.jpg", // Tour 
   5 => "https://i.pinimg.com/736x/93/17/94/9317948052bfaeec707719d8c9058988.jpg", // Infinity Pool 
   6 => "https://i.pinimg.com/736x/24/0a/e5/240ae5bc5e949cf3abce093c1065efe5.jpg"  // 5-Star Restaurant 
]; 
?> 

<!DOCTYPE html> 
<html lang="vi"> 
<head> 
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <title>Danh Sách Dịch Vụ</title> 
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> 
   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> 
   <!-- Add AOS CSS -->
   <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
   <style>
    body {
        font-family: 'Playfair Display', serif;
        background: linear-gradient(rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0.28)), 
            url('https://i.pinimg.com/736x/60/b5/2c/60b52c8596fcc5ab186d36ef2c06edba.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }

    .nav-link {
        color: white;
        font-size: 1.1rem;
        font-weight: 500;
        position: relative;
        transition: color 0.3s ease, transform 0.3s ease;
        padding-bottom: 5px;
    }

    .nav-link:hover {
        color:rgb(255, 255, 255);
        transform: scale(1.05);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color:rgb(255, 255, 255);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link.active {
        color:rgb(255, 255, 255);
        font-weight: 700;
    }

    .nav-link.active::after {
        width: 100%;
    }

    #mobile-menu {
        transition: transform 0.3s ease, opacity 0.3s ease;
        transform: translateY(-10px);
        opacity: 0;
    }

    #mobile-menu:not(.hidden) {
        transform: translateY(0);
        opacity: 1;
    }

    .service-card {
        background: linear-gradient(145deg, #ffffff, #f0f4f8);
        border-radius: 0.75rem;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.52);
    }

    .service-card img {
        transition: transform 0.5s ease;
    }

    .service-card:hover img {
        transform: scale(1.05);
    }

    .book-button {
        margin-top: 1rem;
        background-color: rgba(0, 0, 0, 0.77);
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        transition: background-color 0.4s ease;
    }

    .book-button:hover {
        background-color: rgba(0, 0, 0, 0.53);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.57);
    }

    .logo {
        height: 50px;
        width: auto;
        color: white;
    }

    .logo-text {
        color: white;
        font-size: 18px;
        font-weight: 700;
    }
</style>
</head> 
<body> 
   <header class="relative bg-cover bg-center h-96" style="background-image: url('https://i.pinimg.com/736x/bb/77/f2/bb77f2965b9288479e4987ffc58644e0.jpg')"> 
       <div class="absolute inset-0 bg-black bg-opacity-50"></div> 
       <nav class="container mx-auto px-4 py-4 flex justify-between items-center relative z-10"> 
           <div class="flex items-center space-x-4"> 
               <a href="trangchu.php" class="flex items-center space-x-4"> 
                   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCa4rtF1uHKIwm7hVsWIyWzgyavMKcK120qSXVmcasNrp4cN22" alt="Your Logo" class="logo">                   
                   <span class="logo-text">Maison de Luxe</span> 
               </a> 
           </div> 
           <div class="hidden md:flex space-x-8"> 
               <a href="phong.php" class="nav-link">Hạng Phòng</a> 
               <a href="dichvu.php" class="nav-link active">Dịch vụ</a> 
               <a href="uudai.php" class="nav-link">Ưu đãi</a> 
               <a href="datphong.php" class="nav-link">Liên hệ đặt phòng</a> 
           </div> 
           <button id="menu-toggle" class="md:hidden text-white focus:outline-none"> 
               <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> 
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path> 
               </svg> 
           </button> 
       </nav> 
       <div id="mobile-menu" class="hidden md:hidden bg-blue-600 text-white absolute top-16 right-0 w-full z-10"> 
           <ul class="flex flex-col items-center space-y-4 py-4"> 
               <li><a href="trangchu.php" class="nav-link">Trang Chủ</a></li> 
               <li><a href="phong.php" class="nav-link">Hạng Phòng</a></li> 
               <li><a href="uudai.php" class="nav-link">Ưu Đãi</a></li> 
               <li><a href="datphong.php" class="nav-link">Liên Hệ Đặt Phòng</a></li> 
           </ul> 
       </div> 
       <div class="container mx-auto text-center mt-16 relative z-10"> 
           <h2 class="text-4xl md:text-5xl font-extrabold text-white">Khám Phá Dịch Vụ Sang Trọng</h2> 
           <p class="mt-4 text-lg text-gray-200">Trải nghiệm những dịch vụ tuyệt vời dành riêng cho bạn</p> 
       </div> 
   </header> 

   <main class="container mx-auto py-12 px-4"> 
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> 
           <?php foreach ($services as $index => $service): ?> 
               <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>"> 
                   <img src="<?php echo htmlspecialchars($serviceImages[$service['SERVICEID']]); ?>" alt="<?php echo htmlspecialchars($service['TEN_DICH_VU']); ?>" class="w-full h-48 object-cover rounded-t-lg"> 
                   <div class="p-4"> 
                       <h2 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($service['TEN_DICH_VU']); ?></h2> 
                       <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($service['MOTA']); ?></p> 
                       <p class="text-blue-600 font-bold mt-3 text-lg"><?php echo number_format($service['GIA'], 2, ',', '.') . ' VND'; ?></p> 
                       <button class="book-button" onclick="window.location.href='datdichvu.php'">Đặt Ngay</button>
                   </div> 
               </div> 
           <?php endforeach; ?> 
       </div> 
   </main> 

   <footer class="bg-gray-900 text-white py-8"> 
       <div class="container mx-auto text-center"> 
           <p class="text-lg">© 2025 Dịch Vụ Cao Cấp. All rights reserved.</p> 
       </div> 
   </footer> 

   <!-- Add AOS JS -->
   <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
   <script> 
       // Initialize AOS
       AOS.init({
           duration: 800, // Animation duration in milliseconds
           easing: 'ease-in-out', // Easing function for smooth animation
           once: true // Animation only happens once when scrolling down
       });

       // Mobile menu toggle
       document.getElementById('menu-toggle').addEventListener('click', () => { 
           document.getElementById('mobile-menu').classList.toggle('hidden'); 
       }); 
   </script> 
</body> 
</html>