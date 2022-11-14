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
			if(($this->session->userdata('level') == 'admin') || ($this->session->userdata('level') == 'staf' )){
			}else{
				redirect(base_url("Login"));
			}
	} 
 

 
	function index(){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = '';
		$data['showAkun'] = 'active';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		
		
		$domisili = $this->session->userdata('domisili');
		
		$data["data"] = $this->db->where('domisili',$domisili)->get("akun")->result();
		
		
		$this->template->displayFullStaf('staf/akun/index',$data);
	}
	function formAkun()
	{
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = 'active';
		$data['showAkun'] = '';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		$this->template->displayFullStaf('staf/akun/formAkun',$data);
		
	}
	//untuk mengubah 
	function simpanAkun()
	{
		
		if($this->input->post('save',true))
			{
				
				 $this->form_validation->set_rules('wa', 'wa', 'callback_cek_wa');

					if ($this->form_validation->run() == FALSE)
						{
								$this->formAkun();
						}
						else
						{
				
								$password = $this->input->post('password',true);
								$cP = $password."@ql153Rd@dU";  //kode @ql153Rd@dU adalah tambahan pengaman password
								
								$data = array(		
									'username' => ucwords($this->input->post('username',true)),
									'gender' =>$this->input->post('gender',true),
									'wa' => $this->input->post('wa',true),
									'level' => 'member',
									'password' => password_hash($cP,PASSWORD_DEFAULT,array('cost' => 10)),
									'stt' => $this->input->post('status',true),
									'domisili' => $this->session->userdata('domisili'),
								);
			
									
								$this->db->insert("akun",$data);
									
									echo $this->session->set_flashdata("massage","<div class='col-md-12 '><div class=alert-success align='center'>Berhasil Menambah Akun </div></div>");
									redirect("staf/Akun/index");
						}	
			
			
			
			
			
			}
		else
			{
				redirect("staf/Akun/index");
				
			}
	}
	
	function cek_wa($wa)
	{
		$cek = $this->db->where('wa',$wa)->get('akun')->row();
		
		
		if ($wa == $cek->wa)
                {
                        $this->form_validation->set_message('cek_wa', 'Maaf No Whatsapp anda telah Digunakan Oleh Akun Lain');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
		
	}
	
	
	
	function editAkun($where=0){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = '';
		$data['showAkun'] = 'active';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		$data["data"] = $this->db->where("id",$where)->get("akun")->row();
		$this->template->displayFullStaf('staf/akun/editAkun',$data);
	}
	
	//untuk mengubah 
	function updateAkun()
	{
		
		if($this->input->post('save',true))
			{
				
								$data = array(		
									'namaAkun' => ucwords($this->input->post('namaAkun',true)),
									'email' => $this->input->post('email',true),
									'wa' => $this->input->post('wa',true),
									'alamat' => ucwords($this->input->post('alamat',true)),
									'password' => password_hash($this->input->post('password',true), PASSWORD_DEFAULT,array('cost' => 10)),
								
								);
			
								$where = array("id" => $this->input->post("id",true));
									
								$this->db->update("akun",$data,$where);
									
									echo $this->session->set_flashdata("massage","<div class='col-md-12 '><div class=alert-success align='center'> Data Berhasil Di Edit </div></div>");
									redirect("staf/Akun");
							
			}
		else
			{
				redirect("staf/Akun");
				
			}
	}
 
	function editPas($id=0){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = '';
		$data['showAkun'] = 'active';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		
		$data['id'] = $id; 
		$this->template->displayFullStaf('staf/akun/editPas',$data);
	}
	
	function editPasStaf(){  // edit password cepat staf
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = '';
		$data['showAkun'] = 'active';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		$data['id'] = $this->session->userdata('iduser'); 
		$this->template->displayFullStaf('staf/akun/editPas',$data);
	}
	
	function updatePass()
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
									redirect("staf/Akun");

			}
		else
			{
				redirect("staf/Akun");
				
			}
	}
 
	function editSta($id=0){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = 'active';
		$data['addAkun'] = '';
		$data['showAkun'] = 'active';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		
		
		//untuk di noif
		$data['level'] = 'staf';
		
		
		$data['id']= $id; 
		$data["domisili"] = $this->db->get("domisili")->result();
		$this->template->displayFullStaf('staf/akun/editSta',$data);
	}
	
	function updateSta()
	{
		
		if($this->input->post('save',true))
			{
					
					
					$data = array(		
						
									'domisili' => $this->input->post('domisili',true),
									'level' => $this->input->post('level',true),
									'stt' => $this->input->post('status',true),
								
								);
			
								$where = array('id' => $this->input->post('id',true));
									
								$this->db->update("akun",$data,$where);
									
									echo $this->session->set_flashdata("massage","<div class='col-md-12 '><div class='alert-success' align='center'> Data Berhasil Diubah </div></div>");
									redirect("staf/Akun");

			}
		else
			{
				redirect("staf/Akun");
				
			}
	}
 
	
	
 
 
	
	
	
}