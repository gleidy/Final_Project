<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	function getUsers() {
		$sql = "SELECT * FROM users ORDER BY name;";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->executeQuery($stmt);
		$arrayOfResults = $this->dbManager->fetchResults ( $stmt );
		return $arrayOfResults;
	}
	function getUsersByID($IDValue){
		$sql = "SELECT id, firstname, lastname, email ";
		$sql .= "FROM users ";
		$sql .= "WHERE id = ?";
		$sql .= "ORDER BY name;";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1,$IDValue,$this->dbManager->INT_TYPE);
		
		$this->dbManager->executeQuery ($stmt);
		$arrayOfResults = $this->dbManager->fetchResults ( $stmt );
		return $arrayOfResults;
		
	}
	
	function insertUser($parametersArray) {
		//create an INSERT INTO sql statement (reads the parametersArray - this contains the fields submitted in the HTML5 form
		
		$sql = "INSERT INTO `users` (`name`, `surname`, `email`,`password`) ";
		$sql .= " VALUES (?,?,?,?);";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1,$parametersArray["firstname"],$this->dbManager->STRING_TYPE);
		$this->dbManager->bindValue($stmt, 2,$parametersArray["lastname"],$this->dbManager->STRING_TYPE);
		$this->dbManager->bindValue($stmt, 3,$parametersArray["email"],$this->dbManager->STRING_TYPE);
		$this->dbManager->bindValue($stmt, 4,$parametersArray["password"],$this->dbManager->STRING_TYPE);
		
		//execute the query
		$this->dbManager->executeQuery ($stmt);
		
	}
	
	function deleteUser($IDValue){
		
		$sql = "DELETE FROM `users` ";
		$sql .= "WHERE id = ?";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1,$IDValue,$this->dbManager->INT_TYPE);
		//execute the query
		$this->dbManager->executeQuery ($stmt);
	}
	function updateUser($IDValue, $parametersArray){
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
		$this->dbManager->executeQuery ($stmt);
	}
}
?>
