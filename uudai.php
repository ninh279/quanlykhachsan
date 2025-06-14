<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ưu Đãi & Tin Tức - The Merrion</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        .navbar {
            background: #2c3e50;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }
        .nav-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            margin: 0 20px;
            transition: color 0.3s ease;
        }
        .nav-menu a:hover {
            color: #e74c3c;
        }
        .header {
            text-align: center;
            padding: 50px 20px;
            background: url('https://via.placeholder.com/1200x300') no-repeat center/cover;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .header h1 {
            font-size: 3em;
            margin: 0;
            font-weight: 700;
        }
        .header h2 {
            font-size: 1.5em;
            font-style: italic;
        }
        .content {
            max-width: 1400px; /* Tăng chiều rộng tổng để chứa khoảng cách lớn hơn */
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            justify-content: space-around; /* Tăng khoảng cách ngang */
            flex-wrap: wrap;
        }
        .item {
            width: 30%; /* Điều chỉnh lại để phù hợp với khoảng cách mới */
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-bottom: 40px;
            height: 550px;
            display: flex;
            flex-direction: column;
            margin-right: 20px; /* Thêm khoảng cách ngang giữa các ô */
        }
        .item:last-child {
            margin-right: 0; /* Loại bỏ margin-right cho ô cuối cùng trong hàng */
        }
        .item:hover {
            transform: translateY(-5px);
        }
        .item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .item-content {
            padding: 30px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .item h3 {
            font-size: 1.5em;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .item p {
            font-size: 1em;
            color: #7f8c8d;
            margin-bottom: 0;
        }
        @media (max-width: 768px) {
            .item {
                width: 100%;
                margin-bottom: 20px;
                height: auto;
                margin-right: 0; /* Loại bỏ margin-right trên thiết bị nhỏ */
            }
            .content {
                justify-content: center; /* Căn giữa trên thiết bị nhỏ */
            }
            .nav-menu {
                flex-direction: column;
                text-align: center;
                justify-content: center;
            }
            .nav-menu a {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="nav-menu">
       <a href="trangchu.php">Trang chủ </a>
            <a href="phong.php">Hạng Phòng</a>
            <a href="dichvu.php">Dịch Vụ</a>
            <a href="datphong.php">Liên Hệ Đặt Phòng</a>
        </div>
    </div>
    <div class="header">
        <h1>The Merrion</h1>
        <h2>Ưu Đãi & Tin Tức Đẳng Cấp</h2>
        <p>Cứu sơn phát triển theo cách màu tái The Merrion. Chúng tôi tốt chút niều sư kiện đất và trái nghiệm theo mua. Bạn chắc chắn sẽ tim thấy gi dỡ chuyên cám hứng cho bạn. Bắng cách dẫng kỳ bạn có thể yên tâm cáp nhật.</p>
    </div>
    <div class="content">
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Niềm vui tháng Sáu">
            <div class="item-content">
                <h3>Niềm vui tháng Sáu</h3>
                <p>Merrion Hotel là khúc cánh tran nh hoan hào cho kỳ nghỉ thi giản tháng Sáu, vói tư trương đế tân hứng nhật điệm tham quan tuyệt vôi nhất của Dublin. Tình hương 2 đêm lưu trị bao gồm bán đồi đú kiệu Alien vôi móc chai sám bắn uốc lan tròng phòng cá nhiền.</p>
            </div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Nghỉ ngơi ngập tại The Merrion">
            <div class="item-content">
                <h3>Nghỉ ngơi ngập tại The Merrion</h3>
                <p>Chúc di Ireland của của bắn tai The Merrion két họp sư sang trơng vôi ám áp thc sư của sư chơn chắn thắn. Nhận vào bên dưoi đê kham pha mót sơ la chắn nghi ngạn tuyệt vôi trơng năm nay.</p>
            </div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Kê trọn năm sao">
            <div class="item-content">
                <h3>Kê trọn năm sao</h3>
                <p>Hày thương cho mình mót kỳ nghỉ qua đê vôi trương sắn nh, bắt tôi và bắt sắng vào hơm sau. Mới nhật đân tuyệt vôi!</p>
            </div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Gói nghỉ dưỡng sang trọng">
            <div class="item-content">
                <h3>Gói nghỉ dưỡng sang trọng</h3>
                <p>Trải nghiệm gói nghỉ dưỡng cao cấp với dịch vụ spa miễn phí, bữa tối tại nhà hàng Michelin và view tuyệt đẹp hướng vườn. Chỉ từ 3 đêm lưu trú.</p>
            </div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Ưu đãi gia đình">
            <div class="item-content">
                <h3>Ưu đãi gia đình</h3>
                <p>Đặc biệt cho mùa hè 2025, giảm 20% cho gia đình 4 người, bao gồm bữa sáng buffet và hoạt động vui chơi cho trẻ em.</p>
            </div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/400x300" alt="Dịch vụ spa cao cấp">
            <div class="item-content">
                <h3>Dịch vụ spa cao cấp</h3>
                <p>Thư giãn với liệu trình spa độc quyền, kết hợp massage và trị liệu bằng tinh dầu tự nhiên, chỉ dành cho khách lưu trú từ 2 đêm.</p>
            </div>
        </div>
    </div>
</body>
</html>