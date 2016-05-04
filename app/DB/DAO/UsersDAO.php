<?php

class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id) {
		$sql = "SELECT `user_id`, `password` FROM `users` WHERE `user_id` = ?";
		
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
/*	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO users (first_name, last_name, email, password) ";
		$sql .= "VALUES (?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["first"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["last"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $userID) {
		$sql = "UPDATE `users` SET ";
		
		switch(key($parametersArray)){			
		case "firstname":
			$sql .= "`name` = ? ";
			$sql .= "WHERE id = ?;";
			
			$stmt = $this->dbManager->prepareQuery($sql);
			$this->dbManager->bindValue($stmt, 1,$parametersArray["firstname"],$this->dbManager->STRING_TYPE);
			$this->dbManager->bindValue($stmt, 2,$IDValue,$this->dbManager->INT_TYPE);
			
			break;
		case "lastname":
			$sql .= "`surname` = ? ";
			$sql .= "WHERE id = ?;";
			
			$stmt = $this->dbManager->prepareQuery($sql);			
			$this->dbManager->bindValue($stmt, 1,$parametersArray["lastname"],$this->dbManager->STRING_TYPE);
			$this->dbManager->bindValue($stmt, 2,$IDValue,$this->dbManager->INT_TYPE);
			
			break;
		case "email":
			$sql .= "`email` = ? ";
			$sql .= "WHERE id = ?;";
			
			$stmt = $this->dbManager->prepareQuery($sql);
			$this->dbManager->bindValue($stmt, 1,$parametersArray["email"],$this->dbManager->STRING_TYPE);
			$this->dbManager->bindValue($stmt, 2,$IDValue,$this->dbManager->INT_TYPE);
			
			break;
		case "password":
			$sql .= "`password` = ? ";
			$sql .= "WHERE id = ?;";
			
			$stmt = $this->dbManager->prepareQuery($sql);
			$this->dbManager->bindValue($stmt, 1,$parametersArray["password"],$this->dbManager->STRING_TYPE);
			$this->dbManager->bindValue($stmt, 2,$IDValue,$this->dbManager->INT_TYPE);
				
			break;
		}	
	}
	public function delete($userID) {
		$sql = "DELETE FROM `users` ";
		$sql .= "WHERE id = ?";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1,$IDValue,$this->dbManager->INT_TYPE);
		//execute the query
		$this->dbManager->executeQuery ($stmt);
	}
	public function search($str) {
		$sql = "SELECT users.user_id ";
		$sql .= "FROM users ";
		if ($id != null)
			$sql .= "WHERE users.email LIKE (?) ";
		$sql .= "ORDER BY users.user_id ";
		
		$wild = "%" . $str ."%";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $wild, $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}*/
}
?>
