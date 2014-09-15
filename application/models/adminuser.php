<?php
	class AdminUser extends CI_Model{
	function __construct() {
	parent::__construct();
	}

	function form_insert($data)
	{

		$model = array('username' => $data['username'],
						'password' => md5($data['password']),
						'can_upload_data' => isset($data['can_upload_data']) ? 1 : 0,
						'can_upload_file' => isset($data['can_upload_file']) ? 1 : 0,
						'can_view' => isset($data['can_view']) ? 1 : 0
						 );

		$this->db->insert('admin_user', $model);
	}
}
?>
