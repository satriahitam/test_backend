<?php
	
	class DatabaseService{
		private $db_host = "3.0.56.";
		private $db_name = "shoppingdb";
		private $db_user = "portest";
		private $db_password = "Pa55w0rd";
		private $connection;

		public function getConnection(){
			$this->connection = null;

			try{
				$this->conn = new PDO("mysql:host=".$this->db_host."; dbname = ".$this->db_name, $this->db_user, $this->db_password);
			}catch(PDOException $exception){
				echo "Conncection error!";
			}

			return $this->connection;
		}
	}
?>