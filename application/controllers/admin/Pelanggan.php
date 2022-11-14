<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

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
	
		$data['pelanggan'] = $this->db->get('pelanggan')->result();	
		$this->load->view('admin/pelanggan/index',$data);
	
}


public function kodeCus(){ //kodeCustamer
	

		$data = $this->db->select('MAX(RIGHT(idpelanggan,3)) as id')->from('pelanggan')->get()->row();
		
		if(empty($data))
		{
			$cs= 'Cs001';
			
		}
		else
		{
					$kodeB = (int)$data->id + 1;
					$cs = 'Cs'.sprintf("%03s",$kodeB);
		}
		return  $cs;
	
	
}


public function tambahPelanggan(){
	
			$data = array(
							'idpelanggan' => $this->kodeCus(),
							'namapelanggan' => trim(ucwords($this->input->post('namast',true))),
							'wapelanggan' => trim($this->input->post('wa',true)),
							'alamatpelanggan' => trim($this->input->post('alamat',true)),
							'statuspelanggan' => trim($this->input->post('status',true)),
						);
			$cek = $this->db->insert('pelanggan',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
}

public function ajax_listPelanggan(){
	
	$data['pelanggan'] = $this->db->get('pelanggan')->result();
	$this->load->view('admin/pelanggan/ajax_listPelanggan',$data);
	
	
}

public function updatePelanggan(){
	
			$where = array('idpelanggan' => $this->input->post('idst',true));
			$data = array(
							'namapelanggan' => trim(ucwords($this->input->post('namast',true))),
							'wapelanggan' => $this->input->post('wa',true),
							'alamatpelanggan' => $this->input->post('alamat',true),
							'statuspelanggan' => trim($this->input->post('status',true)),
						);
						
	
			$cek = $this->db->update('pelanggan',$data,$where);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
}



public function getPelangganAuto() //fungsi autocomplete pelanggan
	{   
		
		$cari = $this->input->get('term',true);
		$auto = $this->db->select('*')->from('pelanggan')->like('namapelanggan',$cari)->limit(10)->get()->result();
	
	
	
		if(isset($cari)) 
		{
		  	if(count($auto) == 0) 
			{
				$arr_result[] = array(
						'label'			=>"",
						'idpelanggan' 			=>"",
						'alamat' 			=>"Data Tdk Tersedia",
						'ket'			=> "",
						
					);
			}
			else if(count($auto) > 0)
			{
				foreach ($auto as $row){
					
					$arr_result[] = array(
						'label'			=> $row->namapelanggan,
						'idpelanggan'	=> $row->idpelanggan,
						'alamat'		=> $row->alamatpelanggan,
						'ket'		=> $row->statuspelanggan,
						
					);
				}
				
			}
					echo json_encode($arr_result);
		   	
		}
	}		


















}





