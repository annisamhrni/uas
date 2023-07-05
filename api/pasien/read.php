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
    if(isset($_GET['id'])){
        $item = new Pasien($db);
        $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    
        $item->getSinglePasien();
        if($item->name != null){
            // create array
            $psn_arr = array(
                "id" =>  $item->id,
                "name" => $item->name,
                "tgl_lahir" => $item->tgl_lahir,
                "alamat" => $item->alamat,
                "jenis_kelamin" => $item->jenis_kelamin,
                "kontak" => $item->kontak,
                "created" => $item->created
            );
        
            http_response_code(200);
            echo json_encode($psn_arr);
        }
        else{
            http_response_code(404);
            echo json_encode("Pasien not found.");
        }
    }
    else {
        $items = new Pasien($db);
        $stmt = $items->getPasiens();
        $itemCount = $stmt->rowCount();

        if($itemCount > 0){
            
            $pasienArr = array();
            $pasienArr["body"] = array();
            $pasienArr["itemCount"] = $itemCount;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "tgl_lahir" => $tgl_lahir,
                    "alamat" => $alamat,
                    "jenis_kelamin" => $jenis_kelamin,
                    "kontak" => $kontak,
                    "created" => $created
                );
                array_push($pasienArr["body"], $e);
            }
            echo json_encode($pasienArr);
        }
        else{
            http_response_code(404);
            echo json_encode(
                array("message" => "No record found.")
            );
        }
    }
        
?>
