<?php 
	include "db.php";
	class User{
		protected $db;
		public function __construct(){
			$this->db = new DB_con();
			$this->db = $this->db->ret_obj();
		}
    

	////////////////////////
	// QUERY DES INFO BDD //
	////////////////////////
	public function query_whitelist($id_whitelist){
		
		$query = "SELECT isValidate from players WHERE playerid='$id_whitelist'";			
		$result = $this->db->query($query) or die($this->db->error);
		$user_data = $result->fetch_array(MYSQLI_ASSOC);		
		$QueryResult = $user_data;
		return $QueryResult;
	}
}