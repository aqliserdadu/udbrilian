<?php 
 
class Akun extends CI_Controller{
 
	function __construct(){
		parent::__construct();
			$this->load->library('template');
			$this->load->library('upload'); //load library upload
			$this->load->library('form_validation');
			if($this->session->userdata('status') != "login"){
				redirect(base_url("Login"));
			}
		
		
 
	}
 
 
 


public function cekLevel(){
	
	if($this->session->userdata('level') == 'admin'){
				
		return true;
	}
	else
	{
		$this->load->view('admin/error');
	}
	
}
 
 
 
public function index(){
	if($this->cekLevel())
		{
				$data["data"] = $this->db->get("user")->result();
				$this->load->view('admin/akun/index',$data);
		}

}


public function iduser(){
		$data = $this->db->select('MAX(RIGHT(iduser,2)) as iduser')->from('user')->get()->row();
		
		if(empty($data))
		{
			$iduser = 'Us01';
			
		}
		else
		{
					$kodeB = (int)$data->iduser + 1;
					$iduser = 'Us'.sprintf("%02s",$kodeB);
		}
		return $iduser;
		
		
}
	
public function simpanAkun(){
		
		 $cek = $this->db->where('username',$this->input->post('username',true))->get('user')->row();

					if(!empty($cek))
					{
								echo json_encode(array('status' => false, 'ket' => 'Username Sudah Digunakan'));
					}
					else
					{
				
								$password = $this->input->post('password',true);
								$cP = $password."@ql153Rd@dU";  //kode @ql153Rd@dU adalah tambahan pengaman password
								
								$data = array(	
									'iduser' => $this->iduser(),
									'username' =>$this->input->post('username',true),
									'gender' =>$this->input->post('gender',true),
									'level' => $this->input->post('level',true),
									'password' => password_hash($cP,PASSWORD_DEFAULT,array('cost' => 10)),
									'status' => $this->input->post('status',true),
								);
			
									
								$cek = $this->db->insert("user",$data);
								echo json_encode(array('status' => true, 'ket' => 'Berhasil Menambahkan Akun'));
								
					}	
			
			
		
}

public function updateData(){
		$data = array(		
						
			'username' => $this->input->post('username',true),
			'gender' => $this->input->post('gender',true),
			'level' => $this->input->post('level',true),
			'status' => $this->input->post('status',true),
								
		);
	$where = array('iduser' => $this->input->post('iduser',true));
	$this->db->update("user",$data,$where);
	
	echo json_encode(array('status' => true, 'ket' => 'Berhasil Diupdate'));
		
}
 
	
 
public function ajax_list(){
		$data["data"] = $this->db->get("user")->result();
		$this->load->view('admin/akun/ajax_list',$data);
}
 
 
	

public function updatePass(){
		$iduser = $this->input->post('iduser',true);
		$password = $this->input->post('password',true);
		$cP = $password."@ql153Rd@dU";  //kode @ql153Rd@dU adalah tambahan pengaman password
		$data = array('password' => password_hash($cP,PASSWORD_DEFAULT,array('cost' => 10)));
	
		$this->db->update('user',$data,array('iduser' => $iduser));
	echo json_encode(array('status' => true, 'ket' => 'Password Berhasil Diupdate'));
		
}	
	
	
public function editPas()
{
	
	$this->load->view('admin/akun/editPas');
	
	
}
	
	
	
	
	
}