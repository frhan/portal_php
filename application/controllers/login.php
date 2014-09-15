<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('adminuser');
	}
	public function index()
	{
		//die("user!!");
		$this->load->view('login');
	}

	public function user_login()
	{
		
		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		$username = $_POST['username'];
		$password = $_POST['password'];

		$isValidate = $this->validate_user($username,$password);
		if($isValidate){
			redirect('user');
		}

	}
	
	private function validate_user($username, $password) {
	    // Build a query to retrieve the user's details
	    // based on the received username and password
	    $this->db->from('admin_user');
	    $this->db->where('username',$username );
	    $this->db->where( 'password', md5($password) );
	    $login = $this->db->get()->result();

	    // The results of the query are stored in $login.
	    // If a value exists, then the user account exists and is validated
	    if ( is_array($login) && count($login) == 1 ) {
	        // Call set_session to set the user's session vars via CodeIgniter
	        $this->set_session($login[0]);
	       return true;
	    }

	    return false;
	}

	function set_session($details) 
	{
		$this->session->set_userdata( array(
            'id' => $details->id,
            'name' => $details->username,
            'can_upload_data' => $details->can_upload_data,
            'can_upload_file' => $details->can_upload_file,
            'can_view' => $details->can_view,
            'isLoggedIn'=>true
        	)
   		);
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
