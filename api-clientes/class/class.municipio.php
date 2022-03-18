<?php  

class municipio {

	function __construct() {
		// implementation
   	}

    function list(){
    	$response = array();
    	$connection = new connection();
    	$connect = $connection->connect(); 
    	if ($connect!=null) {
			$response["status"] = true;
	    	try {
				$sql = 'SELECT m.idMunicipio, CONCAT(m.municipio,", ",d.departamento) as municipio 
				FROM municipio as m INNER JOIN departamento as d ON m.idDepartamento=d.idDepartamento';
				$query = $connect->prepare($sql);
		    	if ($query->execute()){
		    		$response["object"] = $query->fetchAll(PDO::FETCH_ASSOC);
					$response["total"] = $query->rowCount();
		    	} else {
		            $response = array(
		            	"status"=>false, 
		            	"msg"=>"No se pudo ejecutar la consulta a la base de datos"
		            );
		        }
			} catch(PDOException $exception) {
		    	$response = array(
		    		"status"=>false, 
		    		"msg"=>"Ocurrió el siguiente error: " . $exception->getMessage()
		    	);
            } finally {
                $connection->disconnect();
            }
	    } else {
	    	$response = array(
	    		"status"=>false, 
	    		"msg"=>"No está conectado al servidor de bases de datos"
	    	);
	    } 
	    return $response;
    }
}

?>