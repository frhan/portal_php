<?php
	class Mdb extends CI_Model{
	
		private $db;
		function __construct() {
			parent::__construct();
		}

		public function connect($config){
			try{
					if (!class_exists('Mongo')){
			            echo ("The MongoDB PECL extension has not been installed or enabled");
			            return false;
			        }
					$connection=  new Mongo();
			    	return $this->db = $connection->selectDB($config['dbname']);
				}catch(Exception $e) {
					return false;
			}

		}
		
	
	}
?>
