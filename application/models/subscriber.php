<?php
	class Subscriber extends CI_Model{
	function __construct() {
	parent::__construct();
	}

	function form_insert($data_array)
	{

		foreach ($data_array as $data) {
		
			$model = array(
			'name' => $data['D'],
			'national_id' => $data['A'],
			'phone_no' => $data['C'],
			'photo_id_no' =>  $data['B']
			);
			try{
				$this->db->insert('subscribers', $model);
			}
			catch(Exception $e){

			}
		}
		return true;
	}

	function getUser($mbNumber)
	{
		if(!isset($mbNumber))
			return false;
		$query = $this->db->get_where('subscribers', array('phone_no' => $mbNumber), 1, 0);
		return $query->result_array();
	}
}
?>
