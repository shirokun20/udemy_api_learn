<?php
header('Content-Type: application/json');
require "./connect.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = array();
    $input    = $_POST;
    $id_news  = str_replace("'", '', @$input['news_id']);

    $sql = "DELETE FROM tb_news WHERE news_id = '$id_news'";
    if ($conn->query($sql)) {
        $response['status']  = 'berhasil';
        $response['message'] = "Berhasil di hapus";
        echo json_encode($response);
    } else {
        $response['status']  = 'gagal';
        $response['message'] = "Gagal di hapus";
        echo json_encode($response);
    }
}
