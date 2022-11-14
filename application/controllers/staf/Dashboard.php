<?php 
 
class Dashboard extends CI_Controller{
 
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
		
		$domisili = $this->session->userdata('domisili');
		
		//untuk class active, ketika di klik
		$data['dashboard'] = 'active';
		$data['akun'] = '';
		$data['addAkun'] = '';
		$data['showAkun'] = '';
		$data['daftarHarga'] = '';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
		$data['daftarHarga'] = '';
		$data['domisili'] = $domisili;
		
		//untuk di noif
		$data['level'] = 'staf';
		
		$iduser = $this->session->userdata('iduser');
		
		
		$data['totalPesanan'] = $this->db->select()->from('akun')->join('transaksi','transaksi.iduser=akun.id')->where('akun.domisili',$domisili)->where_not_in('transaksi.status',array('cancel','list','publis'))->get()->num_rows();
		
		$totalTransaksi = $this->db->select_sum('transaksi.totaltransaksi')->from('akun')->join('transaksi','transaksi.iduser=akun.id')->where('akun.domisili',$domisili)->where_not_in('transaksi.status',array('cancel','list','publis'))->get()->row();
		$data['totalTransaksi'] = $totalTransaksi->totaltransaksi;
		
		$totalPembayaran = $this->db->select_sum('transaksi.totaltransaksi')->from('akun')->join('transaksi','transaksi.iduser=akun.id')->where('akun.domisili',$domisili)->where_not_in('transaksi.status',array('cancel','list','publis','lunas'))->get()->row();
		$data['totalPembayaran'] = $totalPembayaran->totaltransaksi;
		
		$data['banyakProduk'] = $this->db->select('penjualan.namaproduk, sum(penjualan.jumlah) as jumlah, penjualan.satuan')->from('transaksi')->join('akun','akun.id = transaksi.iduser')->join('penjualan','penjualan.idtransaksi=transaksi.idtransaksi')->where('akun.domisili',$domisili)->where_not_in('transaksi.status',array('cancel','list','publis'))->group_by('penjualan.idproduk')->order_by('jumlah','DESC')->get()->result();
		
		$dateN = date('Y-m-d') ; //ambil date kalender hari ini
		$dateS = date('Y-m-d',strtotime('-3 month',strtotime($dateN))); //pengurangan date selama 3 bln
		
		$data['dataPesanan'] = $this->db->select('akun.username, transaksi.idtransaksi, transaksi.status, transaksi.tgltransaksi, transaksi.totaltransaksi, ')->from('transaksi')->join('akun','akun.id=transaksi.iduser')->where('transaksi.thnblnhri >=',$dateS)->where('transaksi.thnblnhri <=',$dateN)->where('akun.domisili',$domisili)->get()->result();
		 
		$data['totalMember'] = $this->db->where('domisili',$domisili)->get('akun')->num_rows();
		
		$data['kontrolOrder'] = $this->db->select('akun.username,akun.wa, transaksi.thnbln')->from('akun')->join('transaksi','transaksi.iduser=akun.id','LEFT')->where('akun.domisili',$domisili)->where_not_in('transaksi.status',array('cancel','list','publis'))->group_by('akun.id')->get()->result();
		$data['renkOrder'] = $this->db->select('akun.username,sum(transaksi.totaltransaksi) as totaltransaksi, count(transaksi.iduser) as hitung, transaksi.thnbln')->from('akun')->join('transaksi','transaksi.iduser=akun.id','LEFT')->where('thnbln',date('Ym'))->where_not_in('transaksi.status',array('cancel','list','publis'))->group_by('akun.id')->order_by('totaltransaksi','DESC')->get()->result();
		
		
		$this->template->displayFullStaf('staf/dashboard',$data);
	}
	
	
	function prosesInbox(){
		
		$id = $this->input->post('id',true);
		$data = array('tx' => 1);   // 1 artinya di terima
		$where = array('idproses' => $id);
		
		$this->db->update('proses',$data,$where);
		
		
		
	}
	
	
	function daftarHarga(){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['akun'] = '';
		$data['addAkun'] = '';
		$data['showAkun'] = '';
		$data['daftarHarga'] = 'active';
		$data['inbox'] = '';
		$data['masuk'] = '';
		$data['proses'] = '';
	
		//untuk di noif
		$data['level'] = 'staf';
		
		$this->template->displayFullStaf('staf/daftarHarga',$data);
	}
	
	function dtProduk(){
		
		header('Content-Type: application/json');
		
		$this->load->library('datatables');
		$this->datatables->select('idproduk,namaproduk,hargaproduk,satuan.satuan,kategori.kategori');
		$this->datatables->from('produk');
		$this->datatables->join('kategori','kategori.idkategori=produk.kategoriproduk');
		$this->datatables->join('satuan','satuan.idsatuan=produk.satuanproduk');
		$this->datatables->add_column('no','');
		echo $this->datatables->generate();
		
		
		
		
		
	}
	
	
	
}