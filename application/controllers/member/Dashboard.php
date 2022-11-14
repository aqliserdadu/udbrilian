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
			if(($this->session->userdata('level') == 'admin') || ($this->session->userdata('level') == 'staf' ) || ($this->session->userdata('level') == 'member' ) ){
			}else{
				redirect(base_url("Login"));
			}
 
 
	}
 
	function index(){
		//untuk class active, ketika di klik
		$data['dashboard'] = 'active';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		$iduser = $this->session->userdata('iduser');
		$data['totalPesanan'] = $this->db->where('iduser',$iduser)->where_not_in('transaksi.status',array('cancel','list'))->get('transaksi')->num_rows();
		
		$totalTransaksi = $this->db->select_sum('totaltransaksi')->where('iduser',$iduser)->where_not_in('status',array('cancel','list'))->get('transaksi')->row();
		$data['totalTransaksi'] = $totalTransaksi->totaltransaksi;
		
		$totalPembayaran = $this->db->select_sum('totaltransaksi')->where('iduser',$iduser)->where_not_in('status',array('cancel','list','lunas'))->get('transaksi')->row();
		$data['totalPembayaran'] = $totalPembayaran->totaltransaksi;
		
		$data['banyakProduk'] = $this->db->select('penjualan.namaproduk, sum(penjualan.jumlah) as jumlah, penjualan.satuan')->from('transaksi')->join('akun','akun.id = transaksi.iduser')->join('penjualan','penjualan.idtransaksi=transaksi.idtransaksi')->where('akun.id',$iduser)->where_not_in('transaksi.status',array('cancel','list'))->group_by('penjualan.idproduk')->order_by('jumlah','DESC')->get()->result();
		
		$dateN = date('Y-m-d') ; //ambil date kalender hari ini
		$dateS = date('Y-m-d',strtotime('-3 month',strtotime($dateN))); //pengurangan date selama 3 bln
		
		$data['dataPesanan'] = $this->db->where('thnblnhri >=',$dateS)->where('thnblnhri <=',$dateN)->where('iduser',$iduser)->order_by('tgltransaksi','DESC')->get('transaksi')->result();
		 
		$this->template->displayFullMember('member/dashboard',$data);
	}
	
	function inbox(){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['inbox'] = 'active';
		$data['daftarHarga'] = '';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		
		$iduser = $this->session->userdata('iduser');
		
		$data['data'] = $this->db->select('transaksi.thnblnhri, proses.idproses, proses.tx, proses.idtransaksi, proses.tglproses, proses.statusproses, proses.noteproses')->from('transaksi')->join('proses','proses.idtransaksi=transaksi.idtransaksi')->where('transaksi.iduser',$iduser)->where_not_in('proses.iduserproses',array(0,$iduser))->where_not_in('proses.tx','2')->where('proses.statusproses !=','publis')->get()->result();

		
		$this->template->displayFullMember('member/inbox',$data);
		
	}
	
	function prosesInbox(){
		
		$id = $this->input->post('id',true);
		$data = array('tx' => 1);   // 1 artinya di terima
		$where = array('idproses' => $id);
		
		$this->db->update('proses',$data,$where);
		
		
		
	}
	
	function hideInbox(){
		
		$id = $this->input->post('id',true);
		$data = array('tx' => 2);   // 2 artinya tidak ditampilkan dihapus dri layar
		$where = array('idproses' => $id);
		
		$this->db->update('proses',$data,$where);
		
		
		
	}
	
	
	function daftarHarga(){
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['inbox'] = '';
		$data['daftarHarga'] = 'active';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		
		$this->template->displayFullMember('member/daftarHarga',$data);
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
	
	function transaksiRinci()
	{
		//untuk class active, ketika di klik
		$data['dashboard'] = 'active';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		$iduser = $this->session->userdata('iduser');
		$data['data'] = $this->db->where('iduser',$iduser)->where_not_in('status',array('cancel','list'))->get('transaksi')->result();
		
		$this->template->displayFullMember('member/transaksiRinci',$data);
		
		
		
	}
	
		function pembayaranRinci()
	{
		//untuk class active, ketika di klik
		$data['dashboard'] = 'active';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = '';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		$iduser = $this->session->userdata('iduser');
		$data['data'] = $this->db->where('iduser',$iduser)->where_not_in('status',array('cancel','lunas'))->get('transaksi')->result();
		
		$this->template->displayFullMember('member/pembayaranRinci',$data);
		
		
		
	}
	
	
	
	
	
	
}