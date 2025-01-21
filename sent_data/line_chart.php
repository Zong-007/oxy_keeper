<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

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
        DATE(`day`) AS formatted_day,  // แปลงจาก DATETIME เป็น วันที่
        AVG(Spo2) AS avg_Spo2
    FROM 
        oxy_table
    WHERE 
        `day` >= CURDATE() - INTERVAL 7 DAY + INTERVAL 12 HOUR  // เริ่มจาก 7 วันที่แล้ว
        AND `day` < CURDATE() + INTERVAL 12 HOUR  // สิ้นสุดก่อนเวลาปัจจุบัน
    GROUP BY 
        DATE(`day`)  // แบ่งข้อมูลตามวันที่
    ORDER BY 
        `day` DESC  // เรียงข้อมูลจากวันที่ล่าสุด
";

// ดำเนินการคำสั่ง SQL สำหรับข้อมูลย้อนหลัง 7 วัน
$result_last_7_days = $conn->query($sql_last_7_days);

// ตัวแปรสำหรับเก็บข้อมูล
$response = [];

// ตัวแปรสำหรับเก็บข้อมูลย้อนหลัง 7 วัน
$last_7_days_data = [];

// สร้าง array สำหรับวันที่ย้อนหลัง 7 วัน (จากวันนี้ไป 7 วัน)
$dates = [];
for ($i = 0; $i < 7; $i++) {
    $dates[] = date('Y-m-d', strtotime('-' . $i . ' days'));
}

// ตรวจสอบผลลัพธ์ของข้อมูลย้อนหลัง 7 วัน
while ($row = $result_last_7_days->fetch_assoc()) {
    // เช็คว่า "formatted_day" อยู่ใน $dates หรือไม่
    $formatted_day = $row['formatted_day'];
    if (in_array($formatted_day, $dates)) {
        // เพิ่มข้อมูลสำหรับวันที่มีในฐานข้อมูล
        $last_7_days_data[$formatted_day] = [
            'day' => $formatted_day,
            'Spo2' => round($row['avg_Spo2'], 2)
        ];
    }
}

// เพิ่มข้อมูลสำหรับวันที่ไม่มีข้อมูลจากฐานข้อมูลเป็นค่า 0
foreach ($dates as $date) {
    if (!isset($last_7_days_data[$date])) {
        $last_7_days_data[$date] = [
            'day' => $date,
            'Spo2' => 0
        ];
    }
}

// เรียงข้อมูลจากวันที่ล่าสุด
ksort($last_7_days_data);

// เพิ่มข้อมูลย้อน 7 วันใน response
$response['last_7_days'] = array_values($last_7_days_data);

// ส่งข้อมูลในรูปแบบ JSON
echo json_encode($response);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
