<?php

require_once '/DB/DAO/UsersDAO.php';
require_once '/DB/pdoDbManager.php';

class CheckValidLogin{
	
	public function CheckValidLogin(){}
	
	public function validate($user,$pass){
		
		$manager = new pdoDbManager();
		$dao = new UsersDAO($manager);
		
		$userInfo = $dao->get($user);
		
		var_dump($userInfo);
		
		if($userInfo["password"] == $pass){		
			return true;
		}
		else
			return false;
		
	}
}

?>