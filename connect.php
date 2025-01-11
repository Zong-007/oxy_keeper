<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "b8rg15mwxwynuk9q.chr7pe7iynqr.eu-west-1.rds.amazonaws.com"; // MySQL Hostname
$username = "syohsd7d2qjppzhk"; // MySQL Username
$password = "l1z5l5w4wb5w4d8v"; // MySQL Password
$dbname = "n68ovjfzoa32kamp"; // ชื่อฐานข้อมูล (เปลี่ยน XXX เป็นชื่อฐานข้อมูลจริง)
$port = 3306; // MySQL Port (ค่าเริ่มต้นคือ 3306)

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $dbname, $port);


?>
