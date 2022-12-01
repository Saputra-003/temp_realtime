<?php
$host = "127.0.0.1";
$user = "root";
$pass = "root";
$db = "iotSuhu";

$koneksi = mysqli_connect($host, $user, $pass, $db);
$data = mysqli_query($koneksi, "SELECT * from suhu ORDER BY jam DESC LIMIT 1");
$no = 1;
foreach ($data as $row) {
    $datax = [
        "jam"   => $row['jam'],
        "suhu"  => (float)$row['suhu']
    ];
}

echo json_encode($datax);
