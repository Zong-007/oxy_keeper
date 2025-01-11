<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "sql202.infinityfree.com"; // MySQL Hostname
$username = "if0_37872897"; // MySQL Username
$password = "iwjuMyabV2NICh"; // MySQL Password
$dbname = "if0_37872897_projectoxy"; // ชื่อฐานข้อมูล (เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริง)
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);


?>
