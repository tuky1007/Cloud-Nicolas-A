<?php
class DataB {
  var $result;			// Resultado del query si es un Select
  var $error;			// Error o resultado del query
  var $enlace;			// Enlace a la BD

  function DB_Connect() {
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $dbase = "data_movil";
	$this->enlace = mysqli_connect($host, $user, $pwd, $dbase);
    
	/* comprobar la conexión */
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
  }

  function DB_Select($query) {
	$result = mysqli_query($this->enlace, $query);
    return $result;
  }
  
  function DB_Numero_Filas($resultado) {
	$número_filas = mysqli_num_rows($resultado);
	return $número_filas;
  }

  function DB_Call_SP($storedp) {
    mysqli_query($this->enlace, $storedp);
  }
  
  function DB_Update($query) {
    mysqli_query($this->enlace, $query);
  }

  function DB_Insert($query) {
    mysqli_query($this->enlace, $query);
  }

  function DB_Delete($query) {  
    mysqli_query($this->enlace, $query);
  }

  function DB_Free_Result($result) {  
    mysqli_free_result($result);
  }
  
  function DB_Fetch_Array($rslt) {
    return mysqli_fetch_array($rslt, MYSQLI_BOTH);
  }
}
?>