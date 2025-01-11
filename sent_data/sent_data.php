<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "b8rg15mwxwynuk9q.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "syohsd7d2qjppzhk"; // MySQL Username
$password = "l1z5l5w4wb5w4d8v"; // MySQL Password
$dbname = "n68ovjfzoa32kamp"; // ชื่อฐานข้อมูล (เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริง)
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// ตั้งค่า timezone
date_default_timezone_set("Asia/Bangkok");

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีค่าที่ส่งผ่าน URL หรือไม่
if (isset($_GET['BPM']) && isset($_GET['Spo2'])) {
    // รับค่าจาก URL
    $bpm = $_GET['BPM'];
    $spo2 = $_GET['Spo2'];
    $timestamp = date("Y-m-d H:i:s"); // เวลาปัจจุบัน

    // ใช้ prepared statement
    $stmt = $conn->prepare("INSERT INTO oxy_table (BPM, Spo2, Date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $bpm, $spo2, $timestamp);

    // ดำเนินการเพิ่มข้อมูล
    if ($stmt->execute()) {
        echo "เพิ่มข้อมูลสำเร็จ! BPM: $bpm, Spo2: $spo2, เวลา: $timestamp";
    } else {
        echo "ข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "กรุณาระบุข้อมูล BPM และ Spo2 ผ่าน URL เช่น ?BPM=90&Spo2=95";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
