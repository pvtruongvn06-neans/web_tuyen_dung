CREATE DATABASE IF NOT EXISTS `web_tuyen_dung` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_tuyen_dung`;

-- 1. Bảng nguoidung
CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` enum('ung_vien','nha_tuyen_dung') NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=16;

INSERT INTO `nguoidung` (`id`, `ho_ten`, `email`, `mat_khau`, `vai_tro`, `sdt`, `created_at`) VALUES
(1, 'Công ty Công nghệ FPT Software', 'hr@fpt.com', '123456', 'nha_tuyen_dung', '0909123456', '2026-11-06 04:10:20'),
(2, 'Tập đoàn Công nghệ Viettel', 'tuyendung@viettel.com.vn', '123456', 'nha_tuyen_dung', '0988777666', '2026-11-06 04:10:20'),
(3, 'Phan Văn Trường', 'truong@gmail.com', '123456', 'ung_vien', '0912345678', '2026-11-06 04:10:20'),
(4, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '123456', 'ung_vien', '0939111222', '2026-11-06 04:10:20'),
(5, 'Công ty TNHH Phần mềm VNG', 'tuyendung@vng.com.vn', '123456', 'nha_tuyen_dung', '0901111222', '2026-11-06 04:33:52'),
(6, 'Ngân hàng VPBank (Khối Công nghệ)', 'careers@vpbank.com.vn', '123456', 'nha_tuyen_dung', '0902222333', '2026-11-06 04:33:52'),
(7, 'Công ty Cổ phần MISA', 'hr@misa.com.vn', '123456', 'nha_tuyen_dung', '0903333444', '2026-11-06 04:33:52'),
(8, 'Công ty Giải pháp An ninh mạng BKAV', 'recruitment@bkav.com', '123456', 'nha_tuyen_dung', '0904444555', '2026-11-06 04:33:52'),
(9, 'Tập đoàn Công nghệ CMC', 'tuyendung@cmc.com.vn', '123456', 'nha_tuyen_dung', '0905555666', '2026-11-06 04:33:52'),
(10, 'Lê Hoàng Nam', 'hoangnam@gmail.com', '123456', 'ung_vien', '0918111222', '2026-11-06 04:33:52'),
(11, 'Trần Thị Thu Thảo', 'thuthao@gmail.com', '123456', 'ung_vien', '0918333444', '2026-11-06 04:33:52'),
(12, 'Phạm Minh Tuấn', 'minhtuan@gmail.com', '123456', 'ung_vien', '0918555666', '2026-11-06 04:33:52'),
(13, 'Võ Văn Đức', 'vanduc@gmail.com', '123456', 'ung_vien', '0918777888', '2026-11-06 04:33:52'),
(14, 'Đặng Mỹ Linh', 'mylinh@gmail.com', '123456', 'ung_vien', '0918999000', '2026-11-06 04:33:52'),
(15, 'Phan Văn Meo', 'meo@gmail.com', '123456', 'ung_vien', '032145987600', '2026-11-06 04:35:27');

-- 2. Bảng tintuyendung
CREATE TABLE `tintuyendung` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tieu_de` varchar(255) NOT NULL,
  `mo_ta` text NOT NULL,
  `yeu_cau` text NOT NULL,
  `dia_diem` varchar(255) NOT NULL,
  `han_nop` date NOT NULL,
  `id_nha_tuyen_dung` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (`id_nha_tuyen_dung`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=15;

INSERT INTO `tintuyendung` (`id`, `tieu_de`, `mo_ta`, `yeu_cau`, `dia_diem`, `han_nop`, `id_nha_tuyen_dung`, `created_at`) VALUES
(1, 'Lập trình viên PHP / Laravel Backend', '- Phát triển và bảo trì các hệ thống Web API RESTful.\n- Tối ưu hóa truy vấn CSDL MySQL và xử lý luồng dữ liệu.\n- Phối hợp với đội ngũ Frontend.', '- Nắm vững kiến thức PHP thuần và Framework (Laravel/CodeIgniter).\n- Thành thạo MySQL, Prepared Statements để chống SQL Injection.\n- Biết sử dụng Git.', 'Cần Thơ', '2026-12-31', 1, '2026-11-06 04:10:20'),
(2, 'Chuyên viên Kiểm thử Phần mềm (QA/Tester)', '- Lập kế hoạch kiểm thử và viết Test case cho hệ thống Web/App.\n- Thực hiện testing và ghi nhận lỗi lên hệ thống quản lý.', '- Tốt nghiệp chuyên ngành CNTT hoặc Mạng máy tính.\n- Cẩn thận, tỉ mỉ, hiểu biết về luồng phần mềm.', 'Cần Thơ (Hybrid)', '2026-12-15', 1, '2026-11-06 04:10:20'),
(3, 'Kỹ sư Quản trị Hệ thống & Mạng (SysAdmin)', '- Quản trị máy chủ Linux (Ubuntu/Debian) và hạ tầng mạng.\n- Cấu hình monitoring (Nagios/NRPE) để theo dõi CPU, RAM.', '- Có kiến thức tốt về CCNA, Linux CLI, SSH.\n- Ưu tiên ứng viên có định hướng Security.', 'TP. Hồ Chí Minh', '2026-11-30', 2, '2026-11-06 04:10:20'),
(4, 'Thực tập sinh Lập trình Web Fullstack', '- Tham gia vào dự án thực tế cùng các Senior Developer.\n- Đọc hiểu tài liệu thiết kế và triển khai giao diện HTML/CSS/JS.', '- Sinh viên năm 3, 4 ngành CNTT.\n- Có tinh thần học hỏi cao và yêu thích lập trình.', 'Cần Thơ', '2026-12-20', 2, '2026-11-06 04:10:20'),
(5, 'Lập trình viên Game Backend (C++/Python)', '- Phát triển server game đa người chơi (MMO).\n- Tối ưu hóa xử lý đồng thời và giảm độ trễ dữ liệu mạng.', '- Thành thạo C++ hoặc Python.\n- Nắm vững kiến thức TCP/IP, Socket Programming.\n- Ưu tiên ứng viên từng làm dự án Game.', 'TP. Hồ Chí Minh', '2026-12-25', 5, '2026-11-06 04:33:52'),
(6, 'Kỹ sư DevOps & Cloud System', '- Xây dựng CI/CD pipeline tự động hóa triển khai ứng dụng.\n- Quản trị hạ tầng Docker, Kubernetes và Cloud AWS.', '- Có kinh nghiệm với Docker, Kubernetes, Ansible.\n- Thành thạo Linux Shell Scripting.\n- Hiểu biết về Security và monitoring.', 'TP. Hồ Chí Minh (Hybrid)', '2026-12-30', 5, '2026-11-06 04:33:52'),
(7, 'Kỹ sư An toàn Thông tin (Pentester)', '- Thực hiện kiểm thử xâm nhập (Penetration Testing) hệ thống ngân hàng số.\n- Phân tích lỗ hổng bảo mật và đề xuất giải pháp khắc phục.', '- Có kiến thức về OWASP Top 10, Binary Exploitation.\n- Sở hữu chứng chỉ CEH, Security+ hoặc tương đương.\n- Tư duy bảo mật tốt.', 'Hà Nội', '2026-12-15', 6, '2026-11-06 04:33:52'),
(8, 'Chuyên viên Phân tích Dữ liệu (Data Analyst)', '- Thu thập, làm sạch và phân tích hành vi giao dịch khách hàng.\n- Xây dựng báo cáo Dashboard kinh doanh phục vụ ban giám đốc.', '- Thành thạo SQL, Python (Pandas, NumPy).\n- Có kỹ năng trực quan hóa dữ liệu (PowerBI/Tableau).', 'Hà Nội', '2026-12-20', 6, '2026-11-06 04:33:52'),
(9, 'Lập trình viên ReactJS Frontend', '- Triển khai giao diện các sản phẩm phần mềm quản trị doanh nghiệp.\n- Tối ưu UI/UX và tốc độ tải trang trên nhiều thiết bị.', '- Thành thạo HTML5, CSS3, JavaScript (ES6+), ReactJS.\n- Có tư duy tốt về Component và State Management.', 'Cần Thơ', '2026-12-28', 7, '2026-11-06 04:33:52'),
(10, 'Kỹ sư Đảm bảo Chất lượng (Automation Tester)', '- Viết kịch bản tự động hóa kiểm thử UI và API (Selenium/Cypress).\n- Tích hợp test tự động vào luồng CI/CD.', '- Am hiểu về quy trình kiểm thử phần mềm.\n- Biết lập trình Java hoặc Python cơ bản.', 'Cần Thơ', '2026-12-18', 7, '2026-11-06 04:33:52'),
(11, 'Chuyên viên Phân tích Mã độc (Malware Analyst)', '- Phân tích hành vi mã độc, virus và lỗ hổng phần mềm.\n- Viết luật nhận dạng cho hệ thống phòng chống mã độc.', '- Thành thạo kỹ thuật Reverse Engineering (Assembly, x64dbg, IDA Pro).\n- Hiểu rõ về Windows Internals và C/C++.', 'Hà Nội', '2026-12-10', 8, '2026-11-06 04:33:52'),
(12, 'Kỹ sư Giám sát An toàn Mạng (SOC Analyst)', '- Giám sát cảnh báo an toàn thông tin 24/7 từ hệ thống SIEM.\n- Xử lý và ứng cứu các sự cố tấn công mạng ban đầu.', '- Nắm vững kiến thức mạng máy tính (Network Protocol, WireShark).\n- Cẩn thận, sẵn sàng ca trực khi cần.', 'Hà Nội', '2026-12-22', 8, '2026-11-06 04:33:52'),
(13, 'Lập trình viên Python Network Automation', '- Viết script tự động hóa cấu hình các thiết bị mạng Cisco, Juniper.\n- Xây dựng tool hỗ trợ quản trị và vận hành mạng nội bộ.', '- Sử dụng tốt Python, thư viện Netmiko/Paramiko.\n- Nắm vững kiến thức Layer 2/Layer 3 networking, SSH.', 'TP. Hồ Chí Minh', '2026-12-29', 9, '2026-11-06 04:33:52'),
(14, 'Chuyên viên Thực thi Dự án CNTT', '- Phối hợp triển khai và chuyển giao các gói giải pháp hạ tầng CNTT.\n- Quản lý tiến độ dự án và làm việc trực tiếp với khách hàng.', '- Tốt nghiệp ngành CNTT, An toàn thông tin hoặc Điện tử viễn thông.\n- Kỹ năng giao tiếp và giải quyết vấn đề tốt.', 'TP. Hồ Chí Minh', '2026-12-12', 9, '2026-11-06 04:33:52');

-- 3. Bảng hosoungtuyen
CREATE TABLE `hosoungtuyen` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_ung_vien` int(11) NOT NULL,
  `id_tin_tuyen_dung` int(11) NOT NULL,
  `duong_dan_cv` varchar(255) NOT NULL,
  `ngay_nop` timestamp NOT NULL DEFAULT current_timestamp(),
  `trang_thai` enum('Da_nop','Duyet','Tu_choi') DEFAULT 'Da_nop',
  FOREIGN KEY (`id_ung_vien`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_tin_tuyen_dung`) REFERENCES `tintuyendung` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=5;

INSERT INTO `hosoungtuyen` (`id`, `id_ung_vien`, `id_tin_tuyen_dung`, `duong_dan_cv`, `ngay_nop`, `trang_thai`) VALUES
(1, 3, 1, 'uploads/cvs/CV_PhanVanTruong.pdf', '2026-11-06 04:10:20', 'Tu_choi'),
(2, 4, 3, 'uploads/cvs/CV_NguyenVanA.pdf', '2026-11-06 04:10:20', 'Duyet'),
(3, 1, 4, 'uploads/cvs/CV_1_1793938269.pdf', '2026-11-06 04:11:09', 'Da_nop'),
(4, 3, 4, 'uploads/cvs/CV_3_1793939201.pdf', '2026-11-06 04:26:41', 'Da_nop');