<?php
header('Content-Type: application/json');
require './connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res      = [];
    $input    = $_POST;
    $username = str_replace("'", '', @$input['username']);
    $email    = str_replace("'", '', @$input['email']);
    $password = str_replace("'", '', @$input['password']);
    $output   = checkEmail($conn, $email);
    if ($username == null) {
        $res['status']  = 'gagal';
        $res['message'] = 'Username jangan kosong!';
    } else if ($password == null) {
        $res['status']  = 'gagal';
        $res['message'] = 'Password jangan kosong!';
    } else if ($output['status'] === 'berhasil') {
        $outpus_in = insertData($conn, [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        $res['status']  = $outpus_in['status'];
        $res['message'] = $outpus_in['message'];
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

function insertData($conn, $data)
{
    $sql = 'INSERT INTO tb_users SET ';
    $sql .= "users_name = '" . $data['username'] . "',";
    $sql .= "users_email = '" . $data['email'] . "',";
    $sql .= "users_pass = '" . md5($data['password']) . "',";
    $sql .= "users_level = 1,";
    $sql .= "users_register_date = now()";
    if ($conn->query($sql) === true) {
        return [
            'status'  => 'berhasil',
            'message' => 'Berhasil mendaftar!',
        ];
    } else {
        return [
            'status'  => 'gagal',
            'message' => 'Gagal mendaftar!',
        ];
    }
}

function checkEmail($conn, $email = null)
{
    if ($email !== null) {
        $sql = 'SELECT users_email ';
        $sql .= 'FROM tb_users ';
        $sql .= 'WHERE users_email = ';
        $sql .= "'" . $email . "'";
        if ($conn->query($sql)->num_rows > 0) {
            return [
                'status'  => 'gagal',
                'message' => 'Email sudah digunakan!',
            ];
        } else {
            return [
                'status'  => 'berhasil',
                'message' => 'Email tersedia!',
            ];
        }
    } else {
        return [
            'status'  => 'gagal',
            'message' => 'Email tidak boleh kosong!',
        ];
    }

}

$conn->close();
