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

// คำสั่ง SQL สำหรับคำนวณค่าเฉลี่ย BPM และ Spo2 ของวันนี้
$sql_today = "
    SELECT 
        AVG(BPM) AS avg_BPM,
        AVG(Spo2) AS avg_Spo2,
        DATE_FORMAT(CURDATE(), '%Y-%m-%d') AS formatted_day
    FROM 
        oxy_table
    WHERE 
        `day` >= CURDATE() - INTERVAL 1 DAY + INTERVAL 12 HOUR
        AND `day` < CURDATE() + INTERVAL 12 HOUR
";

// คำสั่ง SQL สำหรับคำนวณค่าเฉลี่ย BPM และ Spo2 ของเมื่อวาน
$sql_yesterday = "
    SELECT 
        AVG(BPM) AS avg_BPM,
        AVG(Spo2) AS avg_Spo2,
        DATE_FORMAT(CURDATE() - INTERVAL 1 DAY, '%Y-%m-%d') AS formatted_day
    FROM 
        oxy_table
    WHERE 
        `day` >= CURDATE() - INTERVAL 2 DAY + INTERVAL 12 HOUR
        AND `day` < CURDATE() - INTERVAL 1 DAY + INTERVAL 12 HOUR
";

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

// ดำเนินการคำสั่ง SQL สำหรับวันนี้
$result_today = $conn->query($sql_today);

// ดำเนินการคำสั่ง SQL สำหรับเมื่อวาน
$result_yesterday = $conn->query($sql_yesterday);

// ดำเนินการคำสั่ง SQL สำหรับข้อมูลย้อนหลัง 7 วัน
$result_last_7_days = $conn->query($sql_last_7_days);

// ตัวแปรสำหรับเก็บข้อมูล
$response = [];

// ตัวแปรสำหรับเก็บข้อมูลย้อนหลัง 7 วัน
$last_7_days_data = [];

// ตรวจสอบผลลัพธ์ของวันนี้
if ($result_today->num_rows > 0) {
    $row_today = $result_today->fetch_assoc();
    $response['BPM'] = round($row_today['avg_BPM'], 2); // ค่าเฉลี่ย BPM
    $response['Spo2'] = round($row_today['avg_Spo2'], 2); // ค่าเฉลี่ย Spo2
    $response['day'] = $row_today['formatted_day']; // วันที่
} else {
    $response['BPM'] = null;
    $response['Spo2'] = null;
    $response['day'] = null;
}

// ตรวจสอบผลลัพธ์ของเมื่อวาน
if ($result_yesterday->num_rows > 0) {
    $row_yesterday = $result_yesterday->fetch_assoc();
    $response['BPM_Y'] = round($row_yesterday['avg_BPM'], 2); // ค่าเฉลี่ย BPM ของเมื่อวาน
    $response['Spo2_Y'] = round($row_yesterday['avg_Spo2'], 2); // ค่าเฉลี่ย Spo2 ของเมื่อวาน
    $response['day_Y'] = $row_yesterday['formatted_day']; // วันที่ของเมื่อวาน
} else {
    $response['BPM_Y'] = null;
    $response['Spo2_Y'] = null;
    $response['day_Y'] = null;
}

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
