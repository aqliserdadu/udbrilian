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
			if(($this->session->userdata('level') == 'admin') || ($this->session->userdata('level') == 'staf' ) || ($this->session->userdata('level') == 'member' ) ){
			}else{
				redirect(base_url("Login"));
			}
 
	}
 
	
	public function editPas(){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = 'active';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		
		$data['id'] = $this->session->userdata('iduser');
		$this->template->displayFullMember('member/akun/editPas',$data);
	}
	
	public function updatePass()
	{
		
		if($this->input->post('save',true))
			{
					
					$password = $this->input->post('password',true);
						$cP = $password."@ql153Rd@dU";  //kode @ql153Rd@dU adalah tambahan pengaman password
			
					$data = array(		
									
									'password' => password_hash($cP, PASSWORD_DEFAULT,array('cost' => 10)),
								
								);
			
								$where = array('id' => $this->input->post('id',true));
									
								$this->db->update("akun",$data,$where);
									
									echo $this->session->set_flashdata("massage","<div class='col-md-12 '><div class='alert-success' align='center'> Password Berhasil Di Edit </div></div>");
									redirect("member/Akun/editPas");

			}
		else
			{
				redirect("member/Akun/editPas");
				
			}
	}
 
	
	
	
	
}