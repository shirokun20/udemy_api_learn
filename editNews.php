<?php
header('Content-Type: application/json');
require './connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res      = [];
    $input    = $_POST;
    $title = str_replace("'", '', @$input['title']);
    $content    = str_replace("'", '', @$input['content']);
    $desc = str_replace("'", '', @$input['desc']);
    $user_id = str_replace("'", '', @$input['user_id']);
    $id_news = str_replace("'", '', @$input['news_id']);
    // Image
    $image = date('dmYHis').str_replace(' ', '', basename($_FILES['image']['name']));
    $imagePath = './uploads/' . $image;

    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    $output = updateData($conn, [
        'title' => $title,
        'content' => $content,
        'desc' => $desc,
        'image' => $image,
        'id_news' => $id_news,
    ]);

    $res['status'] = $output['status'];
    $res['message'] = $output['message'];
    echo json_encode($res);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Tidak bisa mengakses web ini!'
    ]);
}

function updateData($conn, $data)
{
    $sql = 'UPDATE tb_news SET ';
    $sql .= "news_title = '" . $data['title'] . "',";
    $sql .= "news_content = '" . $data['content'] . "',";
    $sql .= "news_decs = '" . $data['desc'] . "',";
    $sql .= "news_image = '" . $data['image'] . "' ";
    $sql .= "WHERE ";
    $sql .= "news_id = '".$data['id_news'] . "'";
    if ($conn->query($sql) === true) {
        return [
            'status'  => 'berhasil',
            'message' => 'Berhasil mengubah berita!',
        ];
    } else {
        return [
            'status'  => 'gagal',
            'message' => 'Gagal mengubah berita!',
        ];
    }
}


$conn->close();
