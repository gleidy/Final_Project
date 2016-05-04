<?PHP

class ticketsDAO {
	private $dbManager;
	function ticketsDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
		if($id != NULL){
			$sql = "SELECT 	ticket.ticket_id,
							ticket.title,
							ticket.description,
							log.title,
							log.log_entry,
							log.date
					 ";
			$sql .= "FROM ticket ";
			$sql .= "LEFT OUTER JOIN log ON ticket.ticket_id = log.ticket_id ";
			$sql .= "WHERE ticket.ticket_id=? ";
		}
		elseif ($id == NULL){
			$sql = "SELECT * ";
			$sql .= "FROM ticket ";
			$sql .= "ORDER BY ticket.ticket_id";
		}		

		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	public function insert($parametersArray) {
		
		$status = "OPEN";
		$dateTime = date("Y-m-d H:i:s");
		
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO `ticket`(`title`, `description`, `status`, `creation_date`) ";
		$sql .= "VALUES (?,?,?,?)";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["title"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["description"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $status, $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $dateTime,$this->dbManager->STRING_TYPE);
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $id) {
		$dateTime = date("Y-m-d H:i:s");
		
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO `log`(`log_entry`, `ticket_id`, `title`, `creation_date`) ";
		$sql .= "VALUES (?,?,?,?)";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["log_entry"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["title"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $dateTime,$this->dbManager->STRING_TYPE);
		$this->dbManager->executeQuery ( $stmt );
		
		return true;
	}	
public function delete($id) {
		$sql = "UPDATE `ticket` SET `status`=? WHERE ticket_id = ?";
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1,"CLOSED",$this->dbManager->STRING_TYPE);
		$this->dbManager->bindValue($stmt, 2, $id,$this->dbManager->INT_TYPE);
		//execute the query
		$this->dbManager->executeQuery ($stmt);
	}
}
?>
