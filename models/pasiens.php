<?php
    class Pasien{
        // Connection
        private $conn;
        // Table
        private $db_table = "pasien";
        // Columns
        public $id;
        public $name;
        public $tgl_lahir;
        public $alamat;
        public $jenis_kelamin;
        public $kontak;
        public $created;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getPasiens(){
            $sqlQuery = "SELECT id, name, tgl_lahir, alamat, jenis_kelamin, kontak, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createPasien(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        tgl_lahir = :tgl_lahir, 
                        alamat = :alamat, 
                        jenis_kelamin = :jenis_kelamin, 
                        kontak = :kontak, 
                        created = :created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->tgl_lahir=htmlspecialchars(strip_tags($this->tgl_lahir));
            $this->alamat=htmlspecialchars(strip_tags($this->alamat));
            $this->jenis_kelamin=htmlspecialchars(strip_tags($this->jenis_kelamin));
            $this->kontak=htmlspecialchars(strip_tags($this->kontak));
            $this->created=htmlspecialchars(strip_tags($this->created));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":tgl_lahir", $this->tgl_lahir);
            $stmt->bindParam(":alamat", $this->alamat);
            $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
            $stmt->bindParam(":kontak", $this->kontak);
            $stmt->bindParam(":created", $this->created);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // READ single
        public function getSinglePasien(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        tgl_lahir, 
                        alamat, 
                        jenis_kelamin, 
                        kontak, 
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->tgl_lahir = $dataRow['tgl_lahir'];
            $this->alamat = $dataRow['alamat'];
            $this->jenis_kelamin = $dataRow['jenis_kelamin'];
            $this->kontak = $dataRow['kontak'];
            $this->created = $dataRow['created'];
        }        
        // UPDATE
        public function updatePasien(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        tgl_lahir = :tgl_lahir, 
                        alamat = :alamat, 
                        jenis_kelamin = :jenis_kelamin, 
                        kontak = :kontak, 
                        created = :created
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->tgl_lahir=htmlspecialchars(strip_tags($this->tgl_lahir));
            $this->alamat=htmlspecialchars(strip_tags($this->alamat));
            $this->jenis_kelamin=htmlspecialchars(strip_tags($this->jenis_kelamin));
            $this->kontak=htmlspecialchars(strip_tags($this->kontak));
            $this->created=htmlspecialchars(strip_tags($this->created));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":tgl_lahir", $this->tgl_lahir);
            $stmt->bindParam(":alamat", $this->alamat);
            $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
            $stmt->bindParam(":kontak", $this->kontak);
            $stmt->bindParam(":created", $this->created);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        // DELETE
        function deletePasien(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>
