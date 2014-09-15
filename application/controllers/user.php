<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include 'config.php';

class User extends CI_Controller {

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
		$this->load->model('subscriber');
		// $this->load->model('mdb');
		// $config = array(
		// 'username' => 'farhan',
		// 'password' => '123456',
		// 'dbname'   => 'portal',
		// //'cn' 	   => sprintf('mongodb://%s:%d/%s', $hosts, $port,$database),
		// 'connection_string'=> sprintf('mongodb://%s:%d/%s','127.0.0.1','27017','portal'));

		// $this->mdb->connect($config);

		


	}
	public function index()
	{
		if($this->session->userdata('isLoggedIn'))
		{
			$this->load->view('home');
		}else{
			redirect('login');
		}
	}

	public function getUser()
	{
		//echo $_POST['mobile'];
		$mbNumber = $_POST['mobile'];
		$user = $this->subscriber->getUser($mbNumber);
		print_r(json_encode(array_values($user[0])));
	}

	public function uploadFile()
	{
		$this->load->library('mongo');
		$userTable = $this->mongo->db->selectCollection('files');

		$fileName = $_FILES['file']['name'];
		//die($fileName);
		$parts = explode('.', $fileName);
		$mobile = rtrim($parts[0],'C');
		$meta_data = array(
		    'name'=> $fileName,
		    'type'=>'pdf',
		    'mobile' =>$mobile
		);

		$grid = $this->mongo->db->getGridFS();
		$file_id = $grid->storeUpload('file',$meta_data);
		
		$filter = array('mobile'=>$mobile);
		$file_data = $grid->findone($filter);

		redirect('user');

	}

	private function isFileExists($db,$collection,$filter)
	{

	}

	public function getFile()
	{
		$mobile = $_POST['mobile'];
		$this->load->library('mongo');
		$userTable = $this->mongo->db->selectCollection('files');

		$grid = $this->mongo->db->getGridFS();
		$filter = array('mobile'=>$mobile);
		$file_data = $grid->findone($filter);
		//echo $file_data;
		if($file_data)
		{
			//echo "true";
			print_r( base64_encode($file_data->getBytes()));
		}
	}

	public function putSubscriberData()
	{
		
		//die($_FILES['file']['tmp_name']);
		require_once APPPATH."/third_party/Classes/PHPExcel.php"; 

		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

		    if ($row == 1) {
		        $header[$row][$column] = $data_value;
		    } else {
		        $arr_data[$row][$column] = $data_value;
		    }
		}

		$this->insertData($arr_data);
		redirect('user');

	}

	private function insertData($data_array)
	{
		$this->subscriber->form_insert($data_array);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
