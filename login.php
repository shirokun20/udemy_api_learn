<?php
header('Content-Type: application/json');
require './connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res      = [];
    $input    = $_POST;
    $email    = str_replace("'", '', @$input['email']);
    $password = str_replace("'", '', @$input['password']);
    $output   = checkUser($conn, [
        'email' => $email,
        'password' => $password,
    ]);
    if ($output['status'] === 'berhasil') {
        $res['status']  = $output['status'];
        $res['message'] = $output['message'];
        $res['fullname'] = $output['fullname'];
        $res['email'] = $output['email'];
        $res['user_type'] = $output['user_type'];
        $res['user_id'] = $output['user_id'];
    } else {
        $res['status']  = $output['status'];
        $res['message'] = $output['message'];
    }

    echo json_encode($res);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Tidak bisa mengakses web ini!'
    ]);
}


function checkUser($conn, $data = [])
{
    if (@$data['email'] !== null && @$data['password'] !== null) {
        $sql = 'SELECT * ';
        $sql .= 'FROM tb_users ';
        $sql .= 'WHERE ';
        $sql .= "users_email = '" . $data['email'] . "' ";
        $sql .= 'AND ';
        $sql .= "users_pass = '" . md5($data['password']) . "' ";
        if ($conn->query($sql)->num_rows > 0) {
            $output = $conn->query($sql)->fetch_assoc();
            return [
                'status'  => 'berhasil',
                'message' => 'Berhasil masuk ke aplikasi!',
                'fullname' => $output['users_name'],
                'email' => $output['users_email'],
                'user_type' => $output['users_level'],
                'user_id' => $output['users_id']
            ];
        } else {
            return [
                'status'  => 'gagal',
                'message' => 'Email dan Password Tidak ditemukan!',
            ];
        }
    } else {
        return [
            'status'  => 'gagal',
            'message' => 'Email dan Password harus diisi!',
        ];
    }

}

$conn->close();
