<?php 
 
class Hutang extends CI_Controller{
 
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


public function daftarHutang(){
		
		$data['pelanggan'] = $this->db->get('pelanggan')->result();
		$data['data'] = $this->db->select('pelanggan.alamatpelanggan, pelanggan.namapelanggan, (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) as sisahutang, MAX(hutang.date) as date')->from('hutang')->join('pelanggan','pelanggan.idpelanggan=hutang.idpelanggan')->where('hutang.idpelanggan !=','')->group_by('pelanggan.idpelanggan')->get()->result();
		$this->load->view('admin/hutang/daftarHutang',$data);

}

public function ajax_daftarHutang(){
		
		$data['data'] = $this->db->select('pelanggan.alamatpelanggan, pelanggan.namapelanggan, (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) as sisahutang, MAX(hutang.date) as date')->from('hutang')->join('pelanggan','pelanggan.idpelanggan=hutang.idpelanggan')->where('hutang.idpelanggan !=','')->group_by('pelanggan.idpelanggan')->get()->result();
		$this->load->view('admin/hutang/ajax_daftarHutang',$data);

}

 
public function listHutang(){
		
		$data['pelanggan'] = $this->db->get('pelanggan')->result();
		$data['data'] = $this->db->select('pelanggan.alamatpelanggan, pelanggan.namapelanggan,user.username,hutang.totalhutang, hutang.bayarhutang, hutang.kethutang, hutang.idheader, hutang.date, hutang.idhutang')->from('hutang')->join('user','user.iduser=hutang.iduser')->join('pelanggan','pelanggan.idpelanggan=hutang.idpelanggan')->where('hutang.idpelanggan !=','')->order_by('idhutang','desc')->get()->result();
		$this->load->view('admin/hutang/hutang',$data);
	}
	

public function catatHutang(){
	
	
	$data = array(
		
		'iduser' => $this->session->userdata('iduser'),
		'date' => date('Y-m-d'),
		'idpelanggan' => $this->input->post('idpelanggan',true),
		'totalhutang' => str_replace(',','',$this->input->post('nominal',true)),
		'kethutang' => $this->input->post('ket',true),
	
	);
	
	$cek = $this->db->insert('hutang',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
	
}


public function catatPembayaranHutang(){
	
	$idpelanggan = $this->input->post('idpelanggan',true);
	$nilaihutang =  str_replace(',','',$this->input->post('nilaihutang',true));
	$bayarhutang =  str_replace(',','',$this->input->post('bayar',true));
	$sisahutang = str_replace(',','',$this->input->post('sisa',true));
	
	if($nilaihutang >= $bayarhutang){
		$sisa = $sisahutang;
	}else{
		$sisa =0;
	}
	
	$data = array(
		
		'iduser' => $this->session->userdata('iduser'),
		'date' => date('Y-m-d'),
		'idpelanggan' => $idpelanggan,
		'bayarhutang' => $bayarhutang,
		'sisahutang' => $sisa,
		'kethutang' => $this->input->post('ket',true),
	
	);
	
	$cek = $this->db->insert('hutang',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
	
}


public function cekHutang(){

	$idcus = $this->input->post('idcus',true);
	$data = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idpelanggan',$idcus)->get()->row();
	
	$sisahutang = (!empty($data->sisahutang)? $data->sisahutang :0);
	
	if(!empty($data)){
		echo json_encode(array('status' => true, 'sisahutang' => $sisahutang));
	}
	else{
		echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan Mengambil Data Piutang!'));
	}
	


}


public function daftarPiutang(){
		
		$data['suplayer'] = $this->db->get('suplayer')->result();
		$data['data'] = $this->db->select('suplayer.alamatsuplayer, suplayer.namasuplayer, (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) as sisahutang, MAX(hutang.date) AS date')->from('hutang')->join('suplayer','suplayer.idsuplayer=hutang.idsuplayer')->where('hutang.idsuplayer !=','')->group_by('suplayer.idsuplayer')->get()->result();
		$this->load->view('admin/hutang/daftarPiutang',$data);

}


public function listPiutang(){
		
		$data['data'] = $this->db->select('suplayer.alamatsuplayer, suplayer.namasuplayer,user.username,hutang.totalhutang, hutang.bayarhutang, hutang.kethutang, hutang.idheader, hutang.date,hutang.idhutang')->from('hutang')->join('user','user.iduser=hutang.iduser')->join('suplayer','suplayer.idsuplayer=hutang.idsuplayer')->where('hutang.idsuplayer !=','')->order_by('idhutang','desc')->get()->result();
		$this->load->view('admin/hutang/piutang',$data);
	}
	

public function catatPiutang(){
	
	
	$data = array(
		
		'iduser' => $this->session->userdata('iduser'),
		'date' => date('Y-m-d'),
		'idsuplayer' => $this->input->post('idsuplayer',true),
		'totalhutang' => str_replace(',','',$this->input->post('nominal',true)),
		'kethutang' => $this->input->post('ket',true),
	
	);
	
	$cek = $this->db->insert('hutang',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
	
}


public function ajax_daftarPiutang(){
		
		$data['data'] = $this->db->select('suplayer.alamatsuplayer, suplayer.namasuplayer, (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) as sisahutang, MAX(hutang.date) as date')->from('hutang')->join('suplayer','suplayer.idsuplayer=hutang.idsuplayer')->where('hutang.idsuplayer !=','')->group_by('suplayer.idsuplayer')->get()->result();
		$this->load->view('admin/hutang/ajax_daftarPiutang',$data);

}


public function cekPiutang(){

	$idsup = $this->input->post('idsup',true);
	$data = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer',$idsup)->get()->row();
	
	$sisapiutang = (!empty($data->sisahutang)? $data->sisahutang :0);

	if(!empty($data)){
		echo json_encode(array('status' => true, 'sisahutang' => $sisapiutang));
	}
	else{
		echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan Mengambil Data Piutang!'));
	}
	


}


public function catatPembayaranPiutang(){
	
	
	$data = array(
		
		'iduser' => $this->session->userdata('iduser'),
		'date' => date('Y-m-d'),
		'idsuplayer' => $this->input->post('idsuplayer',true),
		'bayarhutang' => str_replace(',','',$this->input->post('bayar',true)),
		'kethutang' => $this->input->post('ket',true),
	
	);
	
	$cek = $this->db->insert('hutang',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
	
	
	
}


function hapus(){  //fungsi akan menghapus hutang / piutang
if($this->session->userdata('level') == 'admin'){
	$id = $this->input->post('idhutang',true);
	
	if(!empty($this->db->delete('hutang',array('idhutang' => $id)))){
		
		echo json_encode(array('status' => true, 'ket' => 'Data Berhasil Dihapus'));
	}else{
		
		echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan, Harap Ulangi kembali'));
	}

}else{
	
		echo json_encode(array('status' => false, 'ket' => 'Tidak Memiliki Izin Untuk Menghapus!!!'));
	
}


}
	
	
		
	
}