<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suplayer extends CI_Controller {

public function __construct()
		{
			parent::__construct();
			$this->load->library('template');
			$this->load->library('upload'); //load library upload
			$this->load->library('form_validation');
			if($this->session->userdata('status') != "login"){
				redirect(base_url("Login"));
			}
			
			
			
		}

public function index(){
	
		$data['sup'] = $this->db->get('suplayer')->result();	
		$this->load->view('admin/suplayer/index',$data);
	
}


public function kodeSup(){ //kodeCustamer
	

		$data = $this->db->select('MAX(RIGHT(idsuplayer,3)) as id')->from('suplayer')->get()->row();
		
		if(empty($data))
		{
			$sp= 'Sup001';
			
		}
		else
		{
					$kodeB = (int)$data->id + 1;
					$sp = 'Sup'.sprintf("%03s",$kodeB);
		}
		return  $sp;
	
	
}


public function tambahSuplayer(){
	
			$data = array(
							'idsuplayer' => $this->kodeSup(),
							'namasuplayer' => trim(ucwords($this->input->post('namast',true))),
							'alamatsuplayer' => trim(ucwords($this->input->post('alamat',true))),
							'wasuplayer' => trim($this->input->post('wa',true)),
							'statussuplayer' => trim($this->input->post('status',true)),
						);
			$cek = $this->db->insert('suplayer',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
}

public function ajax_listSuplayer(){
	
	$data['sup'] = $this->db->get('suplayer')->result();
	$this->load->view('admin/suplayer/ajax_listSuplayer',$data);
	
	
}

public function updateSuplayer(){
	
			$where = array('idsuplayer' => $this->input->post('idst',true));
			$data = array(
							'namasuplayer' => trim(ucwords($this->input->post('namast',true))),
							'alamatsuplayer' =>$this->input->post('alamat',true),
							'wasuplayer' =>$this->input->post('wa',true),
							'statussuplayer' => trim($this->input->post('status',true)),
						);
						
	
			$cek = $this->db->update('suplayer',$data,$where);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
}


public function getSuplayerAuto() //fungsi autocomplete
{   
		
		$cari = $this->input->get('term',true);
		$auto = $this->db->select()->from('suplayer')->where('statussuplayer','On')->like('namasuplayer',$cari)->limit(10)->get()->result();
	
	
	
		if(isset($cari)) 
		{
		  	if(empty($auto)) 
			{
				$arr_result[] = array(
						'label'			=>'',
						'idpsuplayer' 	=>'',
						'alamat' 	=>'Data Tidak Tersedia',
						
					);
			}
			else
			{
				foreach ($auto as $row){
					
					$arr_result[] = array(
						'label'			=> $row->namasuplayer,
						'idsuplayer'	=> $row->idsuplayer,
						'alamat'		=> $row->alamatsuplayer,
						
						
					);
				}
				
			}
					echo json_encode($arr_result);
		   	
		}
	}		


















}





