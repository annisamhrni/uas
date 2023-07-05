<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../models/pasiens.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Pasien($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // Pasien values
    $item->name = $data->name;
    $item->tgl_pinjam = $data->tgl_pinjam;
    $item->alamat = $data->alamat;
    $item->jenis_kelamin = $data->jenis_kelamin;
    $item->kontak = $data->kontak;
    $item->created = date('Y-m-d H:i:s');
    
    if($item->updatePasien()){
        echo json_encode(['message'=>'Pasien updated successfully.']);
    } else{
        echo json_encode(['message'=>'Pasien could not be updated.']);
    }
?>
