<?php
header('Content-Type: application/json');
require './connect.php';
$sql = "SELECT a.*, b.users_name FROM tb_news a, tb_users b where a.users_id = b.users_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  $res = [];
  while($row = $result->fetch_assoc()) {
    $res[] = $row;
  }
  echo json_encode([
    'data' => $res,
    'status' => 'berhasil',
    'message' => 'Data ditemukan',
  ]);
} else {
  echo json_encode([
    'status' => 'gagal',
    'message' => 'tidak ada data',
  ]);
}
$conn->close();