<?php
// กำหนด Content-Type เป็น JSON
header('Content-Type: application/json');

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "b8rg15mwxwynuk9q.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "syohsd7d2qjppzhk"; // MySQL Username
$password = "l1z5l5w4wb5w4d8v"; // MySQL Password
$dbname = "n68ovjfzoa32kamp"; // ชื่อฐานข้อมูล
$port = 3306; // MySQL Port

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    echo json_encode(["error" => "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error]);
    exit();
}

// คำสั่ง SQL สำหรับดึงข้อมูลย้อนหลัง 7 วัน
$sql_last_7_days = "
    SELECT 
        DATE_FORMAT(`day`, '%Y-%m-%d') AS formatted_day,  // วันที่ของแต่ละวัน
        AVG(BPM) AS avg_BPM,
        AVG(Spo2) AS avg_Spo2
    FROM 
        oxy_table
    WHERE 
        `day` >= CURDATE() - INTERVAL 7 DAY + INTERVAL 12 HOUR  // เริ่มจาก 7 วันที่แล้ว
        AND `day` < CURDATE() + INTERVAL 12 HOUR  // สิ้นสุดก่อนเวลาปัจจุบัน
    GROUP BY 
        DATE_FORMAT(`day`, '%Y-%m-%d')  // แบ่งข้อมูลตามวัน
    ORDER BY 
        `day` DESC  // เรียงข้อมูลจากวันที่ล่าสุด
";

// ดำเนินการคำสั่ง SQL สำหรับข้อมูลย้อนหลัง 7 วัน
$result_last_7_days = $conn->query($sql_last_7_days);

// ตัวแปรสำหรับเก็บข้อมูล
$response = [];

// ตัวแปรสำหรับเก็บข้อมูลย้อนหลัง 7 วัน
$last_7_days_data = [];

// ตรวจสอบผลลัพธ์ของข้อมูลย้อนหลัง 7 วัน
if ($result_last_7_days->num_rows > 0) {
    while ($row = $result_last_7_days->fetch_assoc()) {
        $last_7_days_data[] = [
            'day' => $row['formatted_day'], 
            'BPM' => round($row['avg_BPM'], 2),
            'Spo2' => round($row['avg_Spo2'], 2)
        ];
    }
} else {
    $last_7_days_data = null;
}

// เพิ่มข้อมูลย้อนหลัง 7 วันใน response
$response['last_7_days'] = $last_7_days_data;

// ส่งข้อมูลในรูปแบบ JSON
echo json_encode($response);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
