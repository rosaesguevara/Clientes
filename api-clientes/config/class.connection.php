<?php 

class connection {
    
    private $port = "3306";
    private $hostname = "localhost";
    private $database = "dbcliente";
    private $username = "root";
    private $password = "";

    public $connect;

    public function connect(){
        $this->connect = null;
        try {
            $this->connect = new PDO("mysql:host=" . $this->hostname . "; port=" . $this->port . "; dbname=" . $this->database. "; charset=utf8", $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "No se pudo conectar la base de datos: " . $exception->getMessage();
        }
        return $this->connect;
    }

    public function disconnect() {
      	$this->connect = null;
   	}
}  

?>