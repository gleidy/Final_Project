<?php
/**
 * @author Greg Leidy
 */
session_start ();

require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(); // slim run-time object
require_once "conf/config.inc.php"; // include configuration file
require_once 'DB/pdoDbManager.php';
require_once 'DB/DAO/UsersDAO.php';


$app->map ( "/users(/:id)", function ($elementID = null) use($app) {
	$body = $app->request->getBody (); // get the body of the HTTP request (from client)
	$decBody = json_decode ( $body, true ); // this transform the string into an associative array
	$httpMethod = $app->request->getMethod();
	
	// initialisations
	$responseBody = null;
	$responseCode = null;

	$DBMngr = new pdoDbManager();
	$dao = new UsersDAO($DBMngr);
	$DBMngr->openConnection();
	
	switch ($httpMethod) {
		case "GET" :
			
			if ($elementID == NULL){
				$responseBody = $dao->getUsers();
				$responseCode = HTTPSTATUS_OK;		
			}
			elseif ($elementID != NULL){
				$responseBody = $dao->getUsersByID($elementID);
				$responseCode = HTTPSTATUS_OK;			
			}
			else
				$responseCode = HTTPSTATUS_BADREQUEST;
			
			break;
		case "POST" :
			if ($decBody != NULL && $decBody != ""){
				$dao->insertUser($decBody);
				$responseCode = HTTPSTATUS_OK;			
			}
			else
				$responseCode = HTTPSTATUS_BADREQUEST;
			
			break;
		case "PUT" :
			if($elementID != NULL && $decBody != NULL && $decBody != ""){
				$dao->updateUser($elementID, $decBody);
				$responseCode = HTTPSTATUS_OK;
			}
			else
				$responseCode = HTTPSTATUS_BADREQUEST;
			break;
		case "DELETE" :
			if($elementID != NULL){
				$dao->deleteUser($elementID);
				$responseCode = HTTPSTATUS_OK;			
			}
			else
				$responseCode = HTTPSTATUS_BADREQUEST;
			
			break;
	}
	
	$DBMngr->closeConnection();
	
	// return response to client (as a json string)
	if ($responseBody != null)
		$app->response->write ( json_encode ( $responseBody ) ); // this is the body of the response
			                                                         
	// TODO:we need to write also the response codes in the headers to send back to the client
	$app->response->status ( $responseCode );
} )->via ( "GET", "POST", "PUT", "DELETE" );

$app->run ();
?>