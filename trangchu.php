<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison de Luxe</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            position: relative;
            height: 100vh;
            overflow: hidden; /* Prevent overflow */
        }
        .header video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: 1;
            transform: translate(-50%, -50%);
            object-fit: cover; /* Cover the entire header */
        }
        .header:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2; /* Ensure overlay is above video */
        }
        .intro {
            position: relative;
            z-index: 3; /* Ensure text is above overlay */
            max-width: 800px;
            padding: 20px;
            color: white; /* Set text color to white */

}
        
        .intro h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .intro p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .intro a {
            background-color:rgba(255, 255, 255, 0.78);
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            margin-left: auto; /* Đẩy menu sang bên phải */
        }
        .intro a:hover {
            background-color:rgba(250, 250, 250, 0.88);          
}
        .nav {
            background-color: rgba(0, 0, 0, 0.78); /* Màu nền đen trong suốt */
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 4; /* Đảm bảo nav nằm trên mọi thứ */
            display: flex;
            align-items: center; /* Căn giữa theo chiều dọc */
            padding: 15px 20px;
        }
        .nav img {
            height: 50px; /* Set logo height */
            margin-right: 20px; /* Space between logo and links */
        }
        .nav-menu {
            display: flex;
            justify-content: flex-end; /* Giữ menu bên phải */
            flex-grow: 1; /* Chiếm toàn bộ không gian còn lại */
        }
        .nav a {
    color: white; /* Giữ chữ màu trắng */
    text-align: center;
    padding: 15px 20px;
    text-decoration: none;
    font-size: 16px;
    transition:0.4s ease;
}

        .nav a:hover {
            background-color: rgba(255, 255, 255, 0.69); /* Màu nền khi hover */
        }
        .divider {
            background-color: white; /* Color of the divider */
            height: 5px; /* Height of the divider */
            margin:2px  /* điều chỉnh khoảng trắng */
        }
        .container {
            position: relative;
            width: 100%;
            margin: 5px 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: calc(200vh - 400px);
            background-image: url('https://static.vinwonders.com/production/sai-gon-ve-dem-1.jpg');
            background-size: cover;
            background-position: center;
            color: white; /* Set text color to white */
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
        .section {
    flex: 1;
    margin: 20px 0; /* Đặt khoảng cách trên và dưới cho tất cả các mục */
    text-align: center;
    position: relative;
    z-index: 2;
    min-height: 500px; /* Đặt chiều cao tối thiểu cho các mục */
    align-items: center; /* Center content vertically */
    justify-content: center; /* Center content horizontally */
    padding: 20px; /* Thêm khoảng cách bên trong */
}

        .section.vitri {
        min-height: 400px; /* Giảm chiều cao tối thiểu cho mục Vị Trí */
        }

        .section.thuvien {
        min-height: 400px; /* Giảm chiều cao tối thiểu cho mục Thư Viện Ảnh */
         background-size: cover; /* Đảm bảo hình ảnh bao phủ toàn bộ khu vực */
         background-position: center; /* Căn giữa hình ảnh */
        }
        .section:last-child {
            margin-bottom: 0;
        }
        .section h2 {
            color: white; /* Set section title color to white */
            margin-bottom: 20px;
        }
        .section p {
            color: white; /* Set section paragraph color to white */
            line-height: 2.0;
        }
        .amenities, .services, .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .amenity-card, .service-card, .gallery-item {
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            width: 300px;
            height: 200px;
            position: relative;
            overflow: hidden;
            color: white; /* Set card text color to white */
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.7);
        }
        .amenity-card::before, .service-card::before, .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }
        .amenity-card h3, .service-card h3, .gallery-item p {
            position: relative;
            z-index: 2;
            margin: 10px;
        }
        .amenity-card p, .service-card p {
            position: relative;
            z-index: 2;
            margin: 0 10px 10px;
            font-size: 14px;
        }
       .reviews {
    background-color: rgba(255, 255, 255, 0.82);
    padding: 40px;
    border-radius: 10px;
    display: flex; /* Enable flexbox */
    flex-wrap: wrap; /* Allow wrapping for responsiveness */
    gap: 20px; /* Space between review cards */
    justify-content: center; /* Center the cards */
}
.review-card {
    background-size: cover;
    background-position: center;
    border-radius: 8px;
    padding: 20px;
    color: white;
    position: relative;
    height: 150px;
    width: 300px; /* Set a fixed width for consistency */
    display: flex;
    align-items: flex-end; /* Align content to the bottom */
    text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.64);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.review-content {
    background: rgba(0, 0, 0, 0.6); /* Nền mờ cho nội dung */
    padding: 10px;
    border-radius: 5px;
}

.star-rating {
    color: gold; /* Màu vàng cho sao */
    font-size: 18px; /* Kích thước chữ cho sao */
    margin-top: 5px; /* Khoảng cách trên sao */
}
        .footer {
            background-color: #000000; /* Footer background color */
            color: white; /* Footer text color */
            text-align: center;
            padding: 20px;
            width: 100%;
        }

        
        .section.danhgia h2 {
            color: black; /* Đổi màu chữ thành màu đen */
            margin-bottom: 20px;
        }

        .section.Spa,
.section.uudai {
    display: flex; /* Sử dụng flexbox để căn chỉnh nội dung */
    flex-direction: column; /* Căn chỉnh theo chiều dọc */
    align-items: center; /* Căn giữa theo chiều ngang */
    text-align: center; /* Căn giữa nội dung văn bản */
    color: white; /* Đặt màu chữ cho nội dung */
    padding: 50px 20px; /* Thêm khoảng cách bên trong */
}

.section.Spa h2,
.section.uudai h2 {
    font-size: 36px; /* Đặt kích thước chữ cho tiêu đề */
    margin-bottom: 20px; /* Thêm khoảng cách dưới tiêu đề */
    text-align: center; /* Căn giữa tiêu đề */
}

.section.Spa p,
.section.uudai p {
    font-size: 18px; /* Đặt kích thước chữ cho văn bản */
    max-width: 800px; /* Đặt chiều rộng tối đa cho văn bản */
    line-height: 1.6; /* Tăng khoảng cách giữa các dòng */
    text-align: center; /* Căn giữa văn bản */
}

       .section.Spa {
    background-image: url('https://i.pinimg.com/736x/52/bb/04/52bb04e38b5ff859d8a85342dc8c73ec.jpg');
    background-size: cover; /* Đảm bảo hình ảnh bao phủ toàn bộ khu vực */
    background-position: center; /* Căn giữa hình ảnh */
    min-height: 400px; /* Đặt chiều cao tối thiểu cho mục Spa */
    display: flex; /* Sử dụng flexbox để căn chỉnh nội dung */
    align-items: flex-start; /* Căn chỉnh nội dung lên phía trên cùng */
    justify-content: flex-end; /* Đẩy nội dung sang bên phải */
    color: white; /* Đặt màu chữ cho nội dung */
    padding: 20px; /* Thêm khoảng cách bên trong */
    justify-content: center; /* Căn giữa theo chiều ngang */
}
.section.uudai {
    background-image: url('https://i.pinimg.com/736x/e2/77/0c/e2770c202da289366c13055f7a5c8a8b.jpg');
    background-size: cover; /* Đảm bảo hình ảnh bao phủ toàn bộ khu vực */
    background-position: center; /* Căn giữa hình ảnh */
    min-height: 400px; /* Đặt chiều cao tối thiểu cho mục Spa */
    display: flex; /* Sử dụng flexbox để căn chỉnh nội dung */
    align-items: flex-start; /* Căn chỉnh nội dung lên phía trên cùng */
    color: white; /* Đặt màu chữ cho nội dung */
    padding: 20px; /* Thêm khoảng cách bên trong */
    justify-content: center; /* Căn giữa theo chiều ngang */
}
        .location-card {
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            width: 100%;
            height: 400px;
            position: relative;
            overflow: hidden;
            color: white; /* Set card text color to white */
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.7);
            margin: 0 auto; /* Center the card */
            transition: transform 0.4s ease, box-shadow 0.4s ease; /* Thêm hiệu ứng chuyển động */
        }
        .location-card:hover {
            transform: scale(1.08); /* Phóng to ô hình khi hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Thêm bóng cho ô hình */
        }
        .gallery-item {
            transition: transform 0.4s ease, box-shadow 0.4s ease; /* Thêm hiệu ứng chuyển động */
        }
        .gallery-item:hover {
            transform: scale(1.08); /* Phóng to ô hình khi hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Thêm bóng cho ô hình */
        }
        .review-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease; /* Thêm hiệu ứng chuyển động */
        }
        .review-card:hover {
            transform: scale(1.08); /* Phóng to ô hình khi hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Thêm bóng cho ô hình */
        }
.section.Spa,
.section.uudai {
    display: flex;
    flex-direction: column;
    align-items: center; /* Căn giữa theo chiều ngang */
    justify-content: center; /* Căn giữa theo chiều dọc */
    text-align: center; /* Căn giữa văn bản bên trong */
    background-size: cover;
    background-position: center;
    min-height: 400px;
    color: white;
    padding: 20px;
}

.section.Spa h2,
.section.uudai h2 {
    font-size: 36px;
    margin-bottom: 20px;
    text-align: center; /* Đảm bảo tiêu đề được căn giữa */
}

.section.Spa p,
.section.uudai p {
    font-size: 18px;
    max-width: 800px;
    line-height: 1.6;
    text-align: center; /* Đảm bảo đoạn văn được căn giữa */
}
.uudai-link{}
.spa-link {
    background-color:rgba(0, 0, 0, 0.26);
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}
.uudai-link:hover{}
.spa-link:hover {
    background-color:rgba(253, 253, 253, 0.57);
}
    </style>
</head>
<body>
</head>
    <div class="nav">
         <div class="logo-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCa4rtF1uHKIwm7hVsWIyWzgyavMKcK120qSXVmcasNrp4cN22" alt="Logo" />
     </div>
        Maison de Luxe
        <div class="nav-menu">
            <a href="phong.php">Hạng Phòng</a>
            <a href="dichvu.php">Dịch Vụ</a>
            <a href="uudai.php">Ưu Đãi</a>
            <a href="datphong.php">Liên Hệ Đặt Phòng</a>
        </div>
    </div>
    </div>
    <div class="divider"></div> <!-- Dấu gạch ngang -->
    <div class="header">
        <video autoplay muted loop>
            <source src="https://cdn.pixabay.com/video/2024/05/08/211152_large.mp4" type="video/mp4">
        </video>
        <div class="intro">
            <h1>Chào mừng đến với Maison de Luxe</h1>
            <p>“Maison de Luxe – Nơi mọi khoảnh khắc đều đáng nhớ!”</p>
        </div>
    </div>
    <div>
        <div class="divider"></div> <!-- Dấu gạch ngang -->
        <div class="section vitri" style="background-image: url('https://cdn-i.vtcnews.vn/resize/th/upload/2021/07/14/sai-gon-duong-nguyen-1-17160873.jpg');">
            <h2>Vị Trí</h2>
            <p>Khách sạn Maison de Luxe tọa lạc tại trung tâm thành phố, dễ dàng tiếp cận các điểm tham quan nổi tiếng.</p>
            <div class="location-card">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.999999999999!2d106.694215!3d10.79187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175296c269a8a5d%3A0x7c8cc89dcfd21235!2sRustique%20Maison!5e0!3m2!1svi!2s!4v1620000000000!5m2!1svi!2s" 
                    width="60%" 
                    height="300" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
              </div>
            </div>
        </div>
        <div class="divider"></div> <!-- Dấu gạch ngang -->    
        <div class="section thuvien" style="background-image: url('https://i.pinimg.com/736x/16/9a/d6/169ad6a03927636b075f0558afe28d6f.jpg');">
            <h2>Tiện Nghi & Không Gian</h2>
            <p>Khám phá không gian của Maison de Luxe qua những hình ảnh sống động.</p>
            <div class="gallery">
                <div class="gallery-item" style="background-image: url('https://i.pinimg.com/736x/25/d4/2c/25d42cf50985a04e657f49082a5e7791.jpg');">
                    <p>Sảnh khách sạn sang trọng</p>
                </div>
                <div class="gallery-item" style="background-image: url('https://i.pinimg.com/736x/0c/df/0e/0cdf0efbd9dea775b285b1129158aea8.jpg');">
                    <p>Phòng nghỉ hiện đại</p>
                </div>
                <div class="gallery-item" style="background-image: url('https://i.pinimg.com/736x/1d/45/11/1d45111228434e3c8ff1541b2fc5475d.jpg');">
                    <p>Nhà hàng với không gian ấm cúng</p>
                </div>
            </div>
        </div>
       <div class="divider"></div> <!-- Dấu gạch ngang -->
<div class="section Spa" style="background-image: url('https://i.pinimg.com/736x/52/bb/04/52bb04e38b5ff859d8a85342dc8c73ec.jpg');">
    <h2>Spa & Các dịch vụ khác tại Maison de Luxe</h2>
    <p>Thư giãn và tái tạo năng lượng với các dịch vụ cao cấp của chúng tôi, mang đến cho bạn trải nghiệm tuyệt vời nhất.</p>
    <a href="dichvu.php" class="spa-link">Khám phá Dịch Vụ</a>
</div>
<div class="divider"></div> <!-- Dấu gạch ngang -->
<div class="section uudai" style="background-image: url('https://i.pinimg.com/736x/e2/77/0c/e2770c202da289366c13055f7a5c8a8b.jpg');">
    <h2>Tin Tức & Ưu Đãi đặc biệt</h2>
    <p>Khám phá những ưu đãi hấp dẫn và tin tức mới nhất từ Maison de Luxe.</p>
    <a href="uudai.php" class="spa-link">Khám phá Dịch Vụ</a>
    </div>
    </div>
    </div>
        <div class="divider"></div> <!-- Dấu gạch ngang -->    
        <div class="section danhgia reviews" style="background-image: url(' https://i.pinimg.com/736x/14/71/3a/14713acbcef8531935a634371213b58f.jpg');">
    <h2 style="color: #333; margin-bottom: 30px;">Đánh Giá Từ Khách Hàng</h2>
    <div class="reviews">
        <div class="review-card" style="background-image: url('https://i.pinimg.com/736x/c7/eb/8b/c7eb8bee1ebf8b3871572461199cf996.jpg');">
            <div class="review-content">
                <p>"Maison de Luxe tuyệt vời! Nhân viên thân thiện, phòng sạch sẽ và tiện nghi hiện đại. Chắc chắn sẽ quay lại!"</p>
                <p><strong>Nguyễn Văn Ninh</strong></p>
                <div class="star-rating">
                    ★★★★☆
                </div>
            </div>
        </div>
        <div class="review-card" style="background-image: url('https://i.pinimg.com/736x/b5/42/bf/b542bfb05d7120be0dc359069701bb0e.jpg');">
            <div class="review-content">
                <p>"Trải nghiệm tuyệt hảo với hồ bơi vô cực và nhà hàng 5 sao. Rất đáng giá!"</p>
                <p><strong>Nguyễn Ngân Giang</strong></p>
                <div class="star-rating">
                    ★★★★★
                </div>
            </div>
        </div>
        <div class="review-card" style="background-image: url('https://i.pinimg.com/736x/ca/16/cb/ca16cb17e08c6371440005cc635e315f.jpg');">
            <div class="review-content">
                <p>"Dịch vụ spa thật sự đẳng cấp, mang lại cảm giác thư giãn tuyệt đối. Rất recommend!"</p>
                <p><strong>Trần Minh Anh</strong></p>
                <div class="star-rating">
                    ★★★★★
                </div>
            </div>
        </div>
        <div class="review-card" style="background-image: url('https://i.pinimg.com/736x/59/68/e7/5968e708217a338ed524c5677e419ea6.jpg');">
            <div class="review-content">
                <p>"Vị trí trung tâm, tiện lợi cho việc tham quan. Nhân viên hỗ trợ rất nhiệt tình!"</p>
                <p><strong>Lê Hoàng Nam</strong></p>
                <div class="star-rating">
                    ★★★★☆
                </div>
            </div>
        </div>
</div>
<div class="footer">
        <p>© 2025 Maison de Luxe. Mọi quyền được bảo lưu.</p>
    </div>
</body>
</html>
</body>
</html>