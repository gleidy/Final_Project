<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/ticketsDAO.php";
require_once "Validation.php";
class TicketModel {
	private $ticketsDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->ticketsDAO = new ticketsDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getTickets() {
		return ($this->ticketsDAO->get ());
	}
	public function getTicket($id) {
		if (is_numeric ( $id ))
			return ($this->ticketsDAO->get ( $id ));
		
		return false;
	}
	/**
	 *
	 * @param array $UserRepresentation:
	 *        	an associative array containing the detail of the new user
	 */
	public function createNewTicket($newTicket) {
		// compulsory values
		if (! empty ( $newTicket ["title"] ) && ! empty ( $newTicket ["description"] )) {
		
			if ($newId = $this->ticketsDAO->insert( $newTicket ))
				return ($newId);
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function updateTicket($id, $update) {
		if (!empty($update["title"]) && !empty($update["log_entry"])){
			$this->ticketsDAO->update($update, $id);
			return true;
		}
		else
			return false;
		
	}
	public function deleteTicket($id) {
		if(is_numeric($id)){
			$this->ticketsDAO->delete($id);
			return true;
		}
		else
			return false;
	}
	public function __destruct() {
		$this->ticketsDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>