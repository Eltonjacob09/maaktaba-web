<?php
require_once("connection.php");
class MySQLDatabase {
	private $connection;
	
	function __construct(){
		$this->database_connect();
	}
	
	public function database_connect(){
		$this->connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
		if(mysqli_error($this->connection)){
			die('database connection failed'.mysqli_errno());
		}
	}
	public function run_query($query){
		$performQuery=mysqli_query($this->connection,$query);
		if(!$performQuery){
			die('Database query failed');
		}
		return $performQuery;		
	}
	public function return_data($data){
		$all=mysqli_fetch_array($data);
		return $all;
	}
	
	public function fetch_results($data){
        return mysqli_fetch_array($data);
	}
	public function database_prep($string){
		$string=mysqli_real_escape_string($this->connection,$string);
		return $string;
	}
	public function database_affected($query){
		$return=mysqli_num_rows($query);
		return $return;
	}
	
	public function close_database() {
		if(isset($this->connection)) {
			mysqli_close($this->connecion);
			unset($this->connection);
		}
	}
}
$database= new MySQLDatabase();
?>