<?php
require_once "../Slim/Slim.php";
require_once 'CheckValidLogin.php';
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate(\Slim\Route $route){
	
	$validator = new CheckValidLogin();
	
	$app = \Slim\Slim::getInstance();
//	$header = $app->response->headers;	
	$header = $app->request->headers;
	
	if(!empty($header["username"]) && !empty($header["password"])){
		$username = $header["username"];
		$password = $header["password"];
		
		if($validator->validate($username, $password)){
			//auth success
			$responseCode = HTTPSTATUS_OK;
			return true;			
		}
		else 
		//auth fail
			$app->halt(HTTPSTATUS_UNAUTHORIZED);
	}
}

$app->map ( "/tickets(/:id)", "authenticate", function ($ticketID = null) use($app) {
	
	$httpMethod = $app->request->getMethod ();
	$action = null;
	$parameters ["id"] = $ticketID; // prepare parameters to be passed to the controller (example: ID)
	
	if (($ticketID == null) or is_numeric ( $ticketID )) {
		switch ($httpMethod) {
			case "GET" :
				if ($ticketID != null)
					$action = ACTION_GET_TICKET;
				else
					$action = ACTION_GET_TICKETS;
				break;
			case "POST" :
				$action = ACTION_CREATE_TICKET;
				break;
			case "PUT" :
				$action = ACTION_UPDATE_TICKET;
				break;
			case "DELETE" :
				$action = ACTION_DELETE_TICKET;
				break;
			default :
		
	}
	return new loadRunMVCComponents ( "TicketModel", "TicketController", "jsonView", $action, $app, $parameters );
	}
})->via ( "GET", "POST", "PUT", "DELETE" );

$app->run ();
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName (); // common model
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app, $app->headers ); // common view
		$view->output (); // this returns the response to the requesting client
	}
}
?>