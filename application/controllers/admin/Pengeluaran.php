<?php 
 
class Pengeluaran extends CI_Controller{
 
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
	
	$tglP = $this->input->post('tglP',true);
	$tglK = $this->input->post('tglK',true);
	
	$data['tglP'] = $tglP;
	$data['tglK'] = $tglK;
	$data['data'] = $this->db->select('*')->from('pengeluaran')
								->where('date >=',(empty($tglP)? date('Y-m-d'):$tglP))
								->where('date <= ',(empty($tglK)? date('Y-m-d'):$tglK))
								->order_by('idpengeluaran','desc')
								->get()->result();
	$this->load->view('admin/pengeluaran/index',$data);
	
}

public function ajax_listPengeluaran($tglP=null,$tglK=null){
	
	
		
	$data['data'] = $this->db->select('*')->from('pengeluaran')
								->where('date >=',(empty($tglP)? date('Y-m-d'):$tglP))
								->where('date <= ',(empty($tglK)? date('Y-m-d'):$tglK))
								->order_by('idpengeluaran','desc')
								->get()->result();
	$this->load->view('admin/pengeluaran/ajax_listPengeluaran',$data);
	
}


 
public function simpanPengeluaran(){
	
		$date = $this->input->post('date',true);
		$kategori = str_replace(array("'",'"'),"",$this->input->post('kategori',true));
		$nominal = $this->input->post('nominal',true);
		$ket = str_replace(array("'",'"'),"",$this->input->post('ket',true));
		
		$data = array(
				
				'date' => $date,
				'kategori' => ucwords($kategori),
				'nominal' => str_replace(',','',$nominal),
				'ket' => ucwords($ket),
		);
		
		if(!empty($this->db->insert('pengeluaran',$data))){
			
			echo json_encode(array('status' => true));
			die();
			
		}else{
			
			echo json_encode(array('status' => false));
			die();
			
		}
		
		
	
}


 
public function updatePengeluaran(){
	
	$id = $this->input->post('id',true);
	$date = $this->input->post('date',true);
	$kategori = str_replace(array("'",'"'),"",$this->input->post('kategori',true));
	$nominal = $this->input->post('nominal',true);
	$ket = str_replace(array("'",'"'),"",$this->input->post('ket',true));
	
	$data = array(
			
			'date' => $date,
			'kategori' => ucwords($kategori),
			'nominal' => str_replace(',','',$nominal),
			'ket' => ucwords($ket),
	);
	
	if(!empty($this->db->update('pengeluaran',$data,array('idpengeluaran' => $id)))){
		
		echo json_encode(array('status' => true));
		die();
		
	}else{
		
		echo json_encode(array('status' => false));
		die();
		
	}
	
	

}


function laporanPengeluaran(){
	
	$tglP = $this->input->post('tglP',true);
	$tglK = $this->input->post('tglK',true);
	$jenis = empty($this->input->post('jenis',true))? 'rinci':$this->input->post('jenis',true);
	
	if($jenis == 'rekap'){

			$data['tglP'] = $tglP;
			$data['tglK'] = $tglK;
			$data['select'] = $jenis;
			$data['data'] = $this->db->select("SUM(nominal) as nominal,date,kategori,ket")->from('pengeluaran')
										->where('date >=',(empty($tglP)? date('Y-m-').'01':$tglP))
										->where('date <= ',(empty($tglK)? date('Y-m-d'):$tglK))
										->group_by('kategori')
										->order_by('date','ASC')
										->get()->result();	
			$this->load->view('admin/pengeluaran/laporanPengeluaran',$data);
	}else{

			$data['tglP'] = $tglP;
			$data['tglK'] = $tglK;
			$data['select'] = $jenis;
			$data['data'] = $this->db->select("*")->from('pengeluaran')
										->where('date >=',(empty($tglP)? date('Y-m-').'01':$tglP))
										->where('date <= ',(empty($tglK)? date('Y-m-d'):$tglK))
										->order_by('date','ASC')
										->get()->result();	
			$this->load->view('admin/pengeluaran/laporanPengeluaran',$data);

	}
	
}

	


function hapus(){  //fungsi akan menghapus hutang / piutang
if($this->session->userdata('level') == 'admin'){

	$id = $this->input->post('idpengeluaran',true);
	
	if(!empty($this->db->delete('pengeluaran',array('idpengeluaran' => $id)))){
		
		echo json_encode(array('status' => true, 'ket' => 'Data Berhasil Dihapus'));
	}else{
		
		echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan, Harap Ulangi kembali'));
	}
}else{
	
		echo json_encode(array('status' => false, 'ket' => 'Gaga!!!, Tidak Memiliki Akses Untuk Menghapus!'));
}


}
	
	
		
	
}