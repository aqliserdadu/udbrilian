<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	
	
public function __construct()
		{
			parent::__construct();
			$this->load->library('template');
			$this->load->library('form_validation');
			$this->load->library('datatables');
			if($this->session->userdata('status') != "login"){
				redirect(base_url("Login"));
			}
			if(($this->session->userdata('level') == 'admin') || ($this->session->userdata('level') == 'staf' ) || ($this->session->userdata('level') == 'member' ) ){
			}else{
				redirect(base_url("Login"));
			}
 
			
		}

	public function kodeInvoice()
	{
		
		$iduser =  $this->session->userdata('iduser');
		
		$data = $this->db->select('MAX(RIGHT(idtransaksi,2)) as invoice')->from('transaksi')->where('thnbln',date('Ym'))->where('iduser',$iduser)->get()->row();
		
		if(empty($data))
		{
			$invoice = 'INV'.date('Ymd').sprintf("%02s",$iduser).'01';
			
		}
		else
		{
					$kodeB = (int)$data->invoice + 1;
					$invoice = 'INV'.date('Ym').sprintf("%02s",$iduser).sprintf("%02s",$kodeB);
		}
		return $invoice;
		
		
	}
	
	public function addOrder()
	{
		
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = 'active';
		$data['addOrder'] = 'active';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		
		$iduser = $this->session->userdata('iduser');
		$cek = $this->db->where('status','list')->where('iduser',$iduser)->get('transaksi')->row();
		if(!empty($cek))		//jika masih ada list (transaksi blm selesai), maka ini yg di tampilkan
		{
			$invoice = $cek->idtransaksi;
			echo $this->session->set_flashdata("massage","<div class='col-md-12 card'><div class='alert-warning' align='center'> Pesanan Dengan No Invoice ".$invoice." Belum Terselesaikan, Harap Selesaikan!!! </div></div>");
			
		}
		else
		{
			$invoice = $this->kodeInvoice();
		}
		
		
		$data['invoice'] = $invoice;
		$data['data'] = $this->db->where('idtransaksi',$invoice)->get('penjualan')->result();
		$this->template->displayFullMember('member/order/formOrder',$data);
		
	
	}
	
	public function dtProduk()
	{
		
		header('Content-Type: application/json');
		
		$this->load->library('datatables');
		$this->datatables->select('idproduk,namaproduk,hargaproduk,satuan.satuan,kategori.kategori');
		$this->datatables->from('produk');
		$this->datatables->join('kategori','kategori.idkategori=produk.kategoriproduk');
		$this->datatables->join('satuan','satuan.idsatuan=produk.satuanproduk');
		$this->datatables->add_column('pilih', '<a href="javascript:void(0);" class="pilihproduk btn btn-info btn-xs" data-nama="$1" data-harga="$2" data-satuan="$3" data-id="$4">pilih</a>','namaproduk,hargaproduk,satuan,idproduk');
        $this->datatables->add_column('no','');
		echo $this->datatables->generate();
		
		
		
	}
	
	
	//untuk menyimpan input
	public function simpanListOrder()
	{
		
		
		
						$inv = $this->input->post('invoice',true);
						$idproduk = $this->input->post('idproduk',true);
						$namaproduk= $this->input->post('namaproduk',true);
						$satuan= $this->input->post('satuan',true);
						$jumlah  = preg_replace("/[^0-9]/","",$this->input->post('qty',true));
						$harga  = preg_replace("/[^0-9]/","",$this->input->post('harga',true));
						$total = preg_replace("/[^0-9]/","",$this->input->post('total',true));
		
		if(empty($idproduk))
		{
			echo json_encode(array('status' => 'kosong'));
		}
		else
		{
		
			$data = array(
						'idtransaksi' => $inv,
						'idproduk' => $idproduk,
						'namaproduk' => $namaproduk,
						'jumlah' => $jumlah,
						'satuan' => $satuan,
						'harga' => $harga,
						'total' => $total,
					
					);
					
			$cek = $this->db->insert('penjualan',$data);
			
			if($cek)
			{
				echo json_encode(array('status' => true, 'inv' => $inv ));
			}
			else
			{
				echo json_encode(array('status' => false));
			}
		}
		
		
		
	}
	
	
	public function listOrder($invoice)
	{
		
		$data['data'] = $this->db->where('idtransaksi',$invoice)->get('penjualan')->result();
		$this->load->view('member/order/listOrder',$data);
		
	}
	
	public function hapusListOrder($idpenjualan=null)
	{
		
		$cek = $this->db->where('idpenjualan',$idpenjualan)->get('penjualan')->row();
		
		if(empty($cek))
		{
			redirect('member/Order/addOrder');
		}
		else
		{
			$where = array('idpenjualan' => $idpenjualan);
			
			$this->db->delete('penjualan',$where); //delete list
			
			echo $this->session->set_flashdata("list","<div class='col-md-12 card'><div class='alert-danger' align='center'> List Berhasil Di Hapus </div></div>");
			redirect("member/order/addOrder");
						
			
			
		}
	}
	
	
	//untuk menyimpan input
	public function simpanOrder()
	{
		
		if(isset($_POST['simpan']))
		{
			$where = array ('idtransaksi' => $this->input->post('invoice'));
						
			$data = array(
						'iduser' => $this->input->post('user'),
						'iduserproses' => $this->input->post('user'),
						'thnbln' => date('Ym'),
						'thnblnhri' => date('Y-m-d'),
						'status' => 'publis',
						'note' => '',
					);
					
			$this->db->update('transaksi',$data,$where);
			echo $this->session->set_flashdata("success","<div class='col-md-12'><div class='alert-success' align='center'> Transaksi Berhasil Di lakukan </div></div>");
			redirect('member/Order/viewOrder');
			
		}
		else
		{
			
			redirect('member/Order/addOrder');
			
		}
		
		
		
	}
	
	public function viewOrder()
	{
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = 'active';
		$data['addOrder'] = '';
		$data['viewOrder'] = 'active';
		$data['opsiOrder'] = '';
		//untuk di noif
		$data['level'] = 'member';
		
		
		$this->template->displayFullMember('member/order/viewOrder',$data);
		
	}
	
	public function dtOrder() //view data orderan
	{
		$iduser =  $this->session->userdata('iduser');
		header('Content-Type: application/json');
		
		$this->load->library('datatables');
		$this->datatables->select('idtransaksi,tgltransaksi,totaltransaksi,status');
		$this->datatables->from('transaksi');
		$this->datatables->where('iduser',$iduser);
		$this->datatables->add_column('proses', '<a href="javascript:void(0);" class="proses btn btn-info btn-xs" data-id="$1">Lihat</a>','idtransaksi');
		$this->datatables->add_column('item', '<a href="javascript:void(0);" class="item btn btn-success btn-xs" data-id="$1">Item</a>','idtransaksi');
        $this->datatables->add_column('no','');
		echo $this->datatables->generate();
		
	}
	
	public function lihatProsesOrder($invoice=null)
	{
		if(!empty($invoice))
		{
			$cek = $this->db->where('idtransaksi',$invoice)->get('proses')->row();
			if(!empty($cek))
			{
				$data['data'] = $this->db->select('akun.username, proses.idtransaksi,proses.tglproses, proses.noteproses, proses.statusproses')->from('proses')->join('akun','akun.id=proses.iduserproses')->where('idtransaksi',$invoice)->order_by('tglproses','asc')->get()->result();
				$this->load->view('member/order/lihatProsesOrder',$data);
			}
			else
			{
				echo "<div class='alert-info' align='center'> Tidak Ada Jejak Proses, Kemungkinan Telah Dibersihkan </div>";
				
			}
		}
		else
		{
			echo "<div class='alert-warning' align='center'> Maaf Sedang Terjadi Kesalahan </div>";
				
		}
		
	}

	
	public function itemOrder($invoice=null)
	{
		if(!empty($invoice))
		{
			$cek = $this->db->where('idtransaksi',$invoice)->get('penjualan')->row();
			if(!empty($cek))
			{
				$data['data'] = $this->db->where('idtransaksi',$invoice)->get('penjualan')->result();
				$this->load->view('member/order/itemOrder',$data);
			}
			else
			{
				redirect('member/Order/viewOrder');
			}
		}
		else
		{
			redirect('member/Order/viewOrder');
		}
		
	}


	public function opsiOrder()
	{
		//untuk class active, ketika di klik
		$data['dashboard'] = '';
		$data['inbox'] = '';
		$data['daftarHarga'] = '';
		$data['pesanan'] = 'active';
		$data['addOrder'] = '';
		$data['viewOrder'] = '';
		$data['opsiOrder'] = 'active';
		//untuk di noif
		$data['level'] = 'member';
		
		
		$this->template->displayFullMember('member/order/opsiOrder',$data);
		
	}
	
	public function cariTransaksi()
	{
		$invoice = $this->input->post('data');
		$cek = $this->db->where('idtransaksi',$invoice)->get('transaksi')->row();
		
		if(empty($cek))
		{
			echo "<script> alert('Transaksi Tidak DI Temukan, Harap Perikasa No Invoice')</script>";
		}
		else
		{
			
			if($cek->status === 'list')
			{
				echo "<script> alert('Transaksi Belum Lengkap, Harap Lengkapi Di Menu Add Order')</script>";
			}
			else
			{
			
				$data['data'] = $cek;
				$this->load->view('member/order/listOpsi',$data);
			}
		}
		
	}
	
	
	public function editOrder($idtransaksi=null)
	{
		
		$cek = $this->db->where('idtransaksi',$idtransaksi)->get('transaksi')->row();
		
		if(!empty($cek))
		{
			
			if($cek->status === 'terima')
			{
				echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-warning' align='center'> Transaksi Sudah Diterima, Tidak Dapat Melakukan Perubahan </div></div>");
				redirect("member/order/opsiOrder");
			}
			else if($cek->status === 'proses')
			{
				echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-warning' align='center'> Transaksi Sudah Dalam Proses, Tidak Dapat Melakukan Perubahan </div></div>");
				redirect("member/order/opsiOrder");
			}
			else
			{
				
				
				//untuk class active, ketika di klik
				$data['dashboard'] = '';
				$data['inbox'] = '';
				$data['daftarHarga'] = '';
				$data['pesanan'] = 'active';
				$data['addOrder'] = '';
				$data['viewOrder'] = '';
				$data['opsiOrder'] = 'active';
				//untuk di noif
				$data['level'] = 'member';
		
		
				$where = array('idtransaksi' => $idtransaksi);
				$dataUp = array('status' => 'list', 'note' => 'Melakukan Perubahan');
				$this->db->update('transaksi',$dataUp,$where);
				
				
				$invoice = $cek->idtransaksi;
				$data['invoice'] = $invoice;
				$data['data'] = $this->db->where('idtransaksi',$invoice)->get('penjualan')->result();
				$this->template->displayFullMember('member/order/editOrder',$data);
						
			}			
			
			
		}
		else
		{
			echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-info' align='center'> Transaksi Tidak DI Temukan, Harap Perikasa No Invoice </div></div>");
			redirect("member/order/opsiOrder");
		}
	}
	
	public function listOrderEdit($invoice)
	{
		
		$data['data'] = $this->db->where('idtransaksi',$invoice)->get('penjualan')->result();
		$this->load->view('member/order/listOrderEdit',$data);
		
	}
	
	public function updateOrder()
	{
		
		if(isset($_POST['simpan']))
		{
			$where = array('idtransaksi' => $this->input->post('invoice'));
					
			$data = array(
						'totaltransaksi' => $this->input->post('total'),
						'iduser' => $this->input->post('user'),
						'thnbln' => date('Ym'),
						'thnblnhri' => date('Y-m-d'),
						'status' => 'publis',
						
					);
					
			$this->db->update('transaksi',$data,$where);
			echo $this->session->set_flashdata("success","<div class='col-md-12'><div class='alert-success' align='center'> Perubahan Transaksi Berhasil Dilakukan </div></div>");
			redirect('member/Order/viewOrder');
			
		}
		else
		{
			
			redirect('member/Order/addOrder');
			
		}
		
		
		
	}
	
	
	public function batalOrder($idtransaksi=null)
	{
		
		$cek = $this->db->where('idtransaksi',$idtransaksi)->get('transaksi')->row();
		
		if(!empty($cek))
		{
			
			if($cek->status === 'terima')
			{
				echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-warning' align='center'> Transaksi Sudah Diterima, Tidak Dapat Batalkan </div></div>");
				redirect("member/order/opsiOrder");
			}
			else if($cek->status === 'proses')
			{
				echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-warning' align='center'> Transaksi Sudah Dalam Proses, Tidak Dapat Batalkan </div></div>");
				redirect("member/order/opsiOrder");
			}
			else
			{
			
				$where = array('idtransaksi' => $idtransaksi);
				$data = array('status' => 'cancel');
				
				
				$this->db->update('transaksi',$data,$where);
				
				echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-danger' align='center'> Transaksi Berhasil Di Batalkan </div></div>");
				redirect("member/order/opsiOrder");
			}			
			
			
		}
		else
		{
			echo $this->session->set_flashdata("info","<div class='col-md-12 card'><div class='alert-info' align='center'> Transaksi Tidak DI Temukan, Harap Perikasa No Invoice </div></div>");
			redirect("member/order/opsiOrder");
		}
		
		
		
	}
	





}
