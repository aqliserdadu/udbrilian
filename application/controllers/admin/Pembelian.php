<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('upload'); //load library upload
		$this->load->library('form_validation');
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
	}

	public function cekLevel()
	{

		if ($this->session->userdata('level') == 'admin') {

			return true;
		} else {
			$this->load->view('admin/error');
		}
	}





	public function index()
	{

		$tglP = $this->input->get('tglP', true);
		$tglK = $this->input->get('tglK', true);

		$dateSebelum = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))));
		$dateNow = date('Y-m-d');

		$tglP = empty($tglP) ? $dateSebelum : $tglP;
		$tglK = empty($tglK) ? $dateNow : $tglK;


		$data['tglP'] = $tglP;
		$data['tglK'] = $tglK;

		$data['data'] = $this->db->select()->from('header')
			->join('user', 'user.iduser=header.iduser')
			->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
			->where('header.status', 'pmb')
			->where('header.date >=', $tglP)
			->where('header.date <=', $tglK)
			->order_by('header.idheader', 'desc')
			->get()->result();

		$this->load->view('admin/pembelian/index', $data);
	}

	public function addPembelian()
	{

		$cek = $this->db->where_in('status', array('berhasil','Stock Opname'))->like('tanggal', date('Y-m'))->get('sinkronstok')->num_rows();
		if ($cek > 0) {
			$iduser =  $this->session->userdata('iduser');
			$ambil = $this->db->select('MAX(RIGHT(idheader,3)) as invoice')->from('header')->where('date', date('Y-m-d'))->where('iduser', $iduser)->where('status', 'pmb')->get()->row();
			if (empty($ambil)) {
				$invoice = 'PO' . date('Ymd') . $iduser . '001';
			} else {
				$kodeB = (int)$ambil->invoice + 1;
				$invoice = 'PO' . date('Ymd') . $iduser . sprintf("%03s", $kodeB);
			}

			$data['po'] = $invoice;
			$data['user'] = $iduser;
			$data['sp'] = $this->db->where('statussuplayer', 'On')->get('suplayer')->result();
			$this->load->view('admin/pembelian/addPembelian', $data);
		} else {
			// jika verifikasi blm dilakukan masuk kemenu ini.
			echo $this->session->set_flashdata("massage", "<script> alert('Lakukan Proses Sinkron atau Verifikasi terlebih dahulu!!!')</script>");
			redirect(base_url('admin/Barang/sinkronStok'));
		}
	}

	public function getNotaPembelian()
	{
		$iduser =  $_GET['iduser'];
		$ambil = $this->db->select('MAX(RIGHT(idheader,3)) as invoice')->from('header')->where('date', date('Y-m-d'))->where('iduser', $iduser)->where('status', 'pmb')->get()->row();
		if (empty($ambil)) {
			$invoice = 'PO' . date('Ymd') . $iduser . '001';
		} else {
			$kodeB = (int)$ambil->invoice + 1;
			$invoice = 'PO' . date('Ymd') . $iduser . sprintf("%03s", $kodeB);
		}

		echo json_encode(array('status' => true, 'notaPembelian' => $invoice));
	}

	public function listPembelian()
	{

		$data['data'] = $this->db->select()->from('header')
			->join('user', 'user.iduser=header.iduser')
			->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
			->where('header.status', 'pmb')
			->order_by('header.idheader', 'DESC')
			->get()->result();
		$this->load->view('admin/pembelian/listPembelian', $data);
	}

	public function detailPembelian($notaPembelian = null)
	{

		if (!empty($notaPembelian)) {
			$data['row'] = $this->db->select('*')->from('header')
				->join('user', 'user.iduser=header.iduser')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->where('header.idheader', $notaPembelian)
				->get()->row();

			$data['data'] = $this->db->where('idheader', $notaPembelian)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$this->load->view('admin/pembelian/detailPembelian', $data);
		}
	}
	public function simpanPembelian()
	{

		$po = $this->input->post('po', true);

		$iduser = $this->input->post('user', true);
		$date = $this->input->post('date', true);
		$idsuplayer = $this->input->post('idsuplayer', true);

		$cekPo = $this->db->where('idheader', $po)->get('header')->num_rows();
		if ($cekPo > 0) { //jika ada SO yg masuk dan di simpan kembali maka yg sebulmnya di hapus dulu

			//hapus inputan pertama
			if (!$this->hapusDbHeader($po)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
			if (!$this->hapusDbDetail($po)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
			if (!$this->hapusDbHutang($po)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
		}



		$totalsubtotal = str_replace(',', '', $this->input->post('totalsubtotal', true));
		$piutang = str_replace(',', '', $this->input->post('piutang', true));
		$pilihpiutang = $this->input->post('pilihpiutang', true);
		$totalsetelahpiutang = str_replace(',', '', $this->input->post('totalsetelahpiutang'));
		$bongkar = str_replace(',', '', $this->input->post('bongkar', true));
		$totalsetelahbongkar = str_replace(',', '', $this->input->post('totalsetelahbongkar', true));
		$transport = str_replace(',', '', $this->input->post('transport', true));
		$totalsetelahtransport = str_replace(',', '', $this->input->post('totalsetelahtransport', true));
		$totalpembayaran = str_replace(',', '', $this->input->post('totalpembayaran', true));
		$metode = $this->input->post('metode', true);
		$totalbayar =  str_replace(',', '', $this->input->post('totalbayar', true));
		$sisa = str_replace(',', '', $this->input->post('sisa', true));


		if (!$this->db->where('idsuplayer', $idsuplayer)->get('suplayer')->row()) //cek apakah suplayer terdaftar jika tida gagal
		{
			echo json_encode(array('status' => false, 'ket' => 'Suplayer Belum Terdafatar, Daftarkan Terlebih Dulu!'));
			die();
		}

		if ($metode == 'Dp' && $totalbayar >= $totalpembayaran) {
			echo json_encode(array('status' => false, 'ket' => 'DP (Pembayaran tidak boleh lebih besar atau sama dengan Total Pembayaran)!'));
			die();
		}

		if ($metode == 'Tunai' && $pilihpiutang == 'yes') {

			$pembayaranSebelumnnya	= $totalpembayaran - $piutang; //cek nilai totalpembayaran
			//jika metode tunai dan menyertakan ingin membayar piutang maka totalbayar tidak boleh kurang atau sama dengan teransaksi yang akan dilakukan
			if ($totalbayar <= $pembayaranSebelumnnya) {
				echo json_encode(array('status' => false, 'ket' => 'Penyertaan Piutang (Pembayaran tidak boleh lebih kecil atau sama dengan Total Pembayaran)!'));
				die();
			}
		} else if ($metode == 'Tunai' && $pilihpiutang == 'no') {

			if ($metode == 'Tunai' && $totalbayar < $totalpembayaran) {
				echo json_encode(array('status' => false, 'ket' => 'Tunai (Pembayaran tidak boleh lebih kecil dari Total Pembayaran)!'));
				die();
			}
		}

		if ($pilihpiutang == 'yes' && $metode == 'Dp' or $piutang > 0 && $metode == 'Dp') {
			echo json_encode(array('status' => false, 'ket' => 'Pembayaran tidak dapat dilakukan DP, Terkendala dengan Piutang, Gunakan Tunai!'));
			die();
		}




		$hitung = count($_POST['t']);
		$dataDetail = array();
		for ($i = 0; $i < $hitung; $i++) {

			$t = (int)$_POST['t'][$i];
			$l = (int)$_POST['l'][$i];
			$p = (int)$_POST['p'][$i];
			$pcs = (int)$_POST['pcs'][$i];
			$m3 = $_POST['m3'][$i];
			$hargam3 = str_replace(',', '', $_POST['hargam3'][$i]);
			$subtotal = str_replace(',', '', $_POST['subtotal'][$i]);
			$ket = $_POST['ket'][$i];
			$hargasatuan = str_replace(',', '', $_POST['harga'][$i]);
			$kodebarang = $t . $l . $p;

			if ($m3 == 'NaN') {
				echo json_encode(array('status' => false, 'ket' => 'Inputan ada yang tidak sesuai harap priksa kembali (NaN)!'));
				die();
			} else if ($t > '0' && $l > '0' && $p > '0' && $m3 == '0') {
				echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan, Pcs dan Harga M3!'));
				die();
			} else if ($t > '0' && $l > '0' && $p > '0' && $pcs > 0 && $hargam3 == '0') {
				echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan Harga M3!'));
				die();
			} else if ($pcs != '0' && $m3 != '0') {


				$dataDetail[] = array(
					'idheader' => $po,
					'date' => $date,
					'idbarang' => $kodebarang,
					't' => $t,
					'l' => $l,
					'p' => $p,
					'qty'	=> $pcs,
					'm3' => $m3,
					'hargam3' => $hargam3,
					'totalharga' => $subtotal,
					'hargasatuan' => $hargasatuan,
					'ket' => ucwords($ket),
				);
			}
		}

		//insert header

		if ($metode == 'Dp') {

			$totalHarga = $totalpembayaran;
			$sisa = $sisa;
		}
		if ($metode == 'Tunai' && $pilihpiutang == 'no') {

			$totalHarga = $totalpembayaran;
			$sisa = '0';
		}
		if ($metode == 'Tunai' && $pilihpiutang == 'yes') {

			$totalHarga = $totalpembayaran - $piutang;
			$sisa = '0';
		}


		$dataHeader = array(
			'idheader' => $po,
			'iduser' => $iduser,
			'date' => $date,
			'idsuplayer' => $idsuplayer,
			'status' => 'pmb', //pmb artinya pembelian
			'hargatotalawal' => $totalsubtotal,
			'hutang' => $piutang,
			'pilihhutang' => $pilihpiutang,
			'setelahhutang' => $totalsetelahpiutang,
			'bongkar' => $bongkar,
			'hargasetelahbongkar' => $totalsetelahbongkar,
			'transport' => $transport,
			'hargasetelahtransport' => $totalsetelahtransport,
			'totalharga' => $totalHarga,
			'metodebayar' => $metode,
			'bayar' => $totalbayar,
			'sisa' => $sisa,
		);
		if (!$this->db->insert('header', $dataHeader)) {

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbHutang($po);
			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}


		//insert detail

		if (!$this->db->insert_batch('detail_header', $dataDetail)) {  //insert multie detail

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbHutang($po);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}

		//insert menggunakan DP berati insert tabel piutang kesuplayer
		if ($metode == 'Dp') {

			$datapiutang = array(

				'iduser' => $iduser,
				'idheader' => $po,
				'date' => $date,
				'idsuplayer' => $idsuplayer,
				'totalhutang' => $sisa,
				'kethutang' => 'Piutang',
			);
			if (!$this->db->insert('hutang', $datapiutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($po);
				$this->hapusDbDetail($po);
				$this->hapusDbHutang($po);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		// end insert piutang kesuplayer

		//cek hutang;
		if ($piutang > 0 && $pilihpiutang == 'yes') { //menyertakan pembayaran hutang

			if ($totalbayar >= $totalpembayaran) {  // jika nilai bayar lebih besar dari total pembayaran,
				// makan nilai bayar hutang adalah sama dengan nilai sisa piutang
				$nilaibayarhutang = $piutang;
				$sisahutang = 0;
				$kethutang = 'Lunas';
			} else {  //jika tidak lebih besar maka akan di ambil dari sisa pembayaran yang dilakukan

				$ceknilai	= $totalpembayaran - $piutang; //cek nilai totalpembayaran
				$nilaibayarhutang =  $totalbayar - $ceknilai;
				$sisahutang = $piutang - $nilaibayarhutang;
				$kethutang = 'Cicilan';
			}

			$databayarhutang = array(
				'iduser' => $iduser,
				'idheader' => $po,
				'date' => $date,
				'idsuplayer' => $idsuplayer,
				'bayarhutang' => $nilaibayarhutang,
				'sisahutang' => $sisahutang,
				'kethutang' => $kethutang,
			);

			if (!$this->db->insert('hutang', $databayarhutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($po);
				$this->hapusDbDetail($po);
				$this->hapusDbHutang($po);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		//end hutang

		echo json_encode(array('status' => true, 'ket' => 'Berhasil Di Simpan!'));
		die();
	}

	public function updatePembelian()
	{

		$po = $this->input->post('po', true);
		$iduser = $this->input->post('user', true);
		$date = $this->input->post('date', true);
		$idsuplayer = $this->input->post('idsuplayer', true);

		$totalsubtotal = str_replace(',', '', $this->input->post('totalsubtotal', true));
		$piutang = str_replace(',', '', $this->input->post('piutang', true));
		$pilihpiutang = $this->input->post('pilihpiutang', true);
		$totalsetelahpiutang = str_replace(',', '', $this->input->post('totalsetelahpiutang', true));
		$bongkar = str_replace(',', '', $this->input->post('bongkar', true));
		$totalsetelahbongkar = str_replace(',', '', $this->input->post('totalsetelahbongkar', true));
		$transport = str_replace(',', '', $this->input->post('transport', true));
		$totalsetelahtransport = str_replace(',', '', $this->input->post('totalsetelahtransport', true));
		$totalpembayaran = str_replace(',', '', $this->input->post('totalpembayaran', true));
		$metode = $this->input->post('metode', true);
		$totalbayar =  str_replace(',', '', $this->input->post('totalbayar', true));
		$sisa = str_replace(',', '', $this->input->post('sisa', true));


		if (!$this->db->where('idsuplayer', $idsuplayer)->get('suplayer')->row()) //cek apakah suplayer terdaftar jika tida gagal
		{
			echo json_encode(array('status' => false, 'ket' => 'Suplayer Belum Terdafatar, Daftarkan Terlebih Dulu!'));
			die();
		}

		if ($metode == 'Dp' && $totalbayar >= $totalpembayaran) {
			echo json_encode(array('status' => false, 'ket' => 'DP (Pembayaran tidak boleh lebih besar atau sama dengan Total Pembayaran)!'));
			die();
		}

		if ($metode == 'Tunai' && $pilihpiutang == 'yes') {

			$pembayaranSebelumnnya	= $totalpembayaran - $piutang; //cek nilai totalpembayaran
			//jika metode tunai dan menyertakan ingin membayar piutang maka totalbayar tidak boleh kurang atau sama dengan teransaksi yang akan dilakukan
			if ($totalbayar <= $pembayaranSebelumnnya) {
				echo json_encode(array('status' => false, 'ket' => 'Penyertaan Piutang (Pembayaran tidak boleh lebih kecil atau sama dengan Total Pembayaran)!'));
				die();
			}
		} else if ($metode == 'Tunai' && $pilihpiutang == 'no') {

			if ($metode == 'Tunai' && $totalbayar < $totalpembayaran) {
				echo json_encode(array('status' => false, 'ket' => 'Tunai (Pembayaran tidak boleh lebih kecil dari Total Pembayaran)!'));
				die();
			}
		}

		if ($pilihpiutang == 'yes' && $metode == 'Dp' or $piutang > 0 && $metode == 'Dp') {
			echo json_encode(array('status' => false, 'ket' => 'Pembayaran tidak dapat dilakukan DP, Terkendala dengan Piutang, Gunakan Tunai!'));
			die();
		}




		$hitung = count($_POST['t']);
		$dataDetail = array();
		for ($i = 0; $i < $hitung; $i++) {

			$t = (int)$_POST['t'][$i];
			$l = (int)$_POST['l'][$i];
			$p = (int)$_POST['p'][$i];
			$pcs = (int)$_POST['pcs'][$i];
			$m3 = $_POST['m3'][$i];
			$hargam3 = str_replace(',', '', $_POST['hargam3'][$i]);
			$subtotal = str_replace(',', '', $_POST['subtotal'][$i]);
			$ket = $_POST['ket'][$i];
			$hargasatuan = str_replace(',', '', $_POST['harga'][$i]);
			$kodebarang = $t . $l . $p;


			if ($m3 == 'NaN') {
				echo json_encode(array('status' => false, 'ket' => 'Inputan ada yang tidak sesuai harap priksa kembali!'));
				die();
			} else if ($t > '0' && $l > '0' && $p > '0' && $m3 == '0') {
				echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan, Pcs dan Harga M3!'));
				die();
			} else if ($t > '0' && $l > '0' && $p > '0' && $pcs > 0 && $hargam3 == '0') {
				echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan Harga M3!'));
				die();
			} else if ($pcs != '0' && $m3 != '0') {

				$dataDetail[] = array(
					'idheader' => $po,
					'date' => $date,
					'idbarang' => $kodebarang,
					't' => $t,
					'l' => $l,
					'p' => $p,
					'qty'	=> $pcs,
					'm3' => $m3,
					'hargam3' => $hargam3,
					'totalharga' => $subtotal,
					'hargasatuan' => $hargasatuan,
					'ket' => ucwords($ket),
				);
			}
		}


		//hapus inputan pertama
		if (!$this->hapusDbHeader($po)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
			die();
		}
		if (!$this->hapusDbDetail($po)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
			die();
		}
		if (!$this->hapusDbHutang($po)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
			die();
		}


		//insert data kembali
		//insert header

		if ($metode == 'Dp') {

			$totalHarga = $totalpembayaran;
			$sisa = $sisa;
		}
		if ($metode == 'Tunai' && $pilihpiutang == 'no') {

			$totalHarga = $totalpembayaran;
			$sisa = '0';
		}
		if ($metode == 'Tunai' && $pilihpiutang == 'yes') {

			$totalHarga = $totalpembayaran - $piutang;
			$sisa = '0';
		}
		$dataHeader = array(
			'idheader' => $po,
			'iduser' => $iduser,
			'date' => $date,
			'idsuplayer' => $idsuplayer,
			'status' => 'pmb', //pmb artinya pembelian
			'hargatotalawal' => $totalsubtotal,
			'hutang' => $piutang,
			'pilihhutang' => $pilihpiutang,
			'setelahhutang' => $totalsetelahpiutang,
			'bongkar' => $bongkar,
			'hargasetelahbongkar' => $totalsetelahbongkar,
			'transport' => $transport,
			'hargasetelahtransport' => $totalsetelahtransport,
			'totalharga' => $totalHarga,
			'metodebayar' => $metode,
			'bayar' => $totalbayar,
			'sisa' => $sisa,
		);
		if (!$this->db->insert('header', $dataHeader)) {

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbHutang($po);
			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}

		//insert detail
		if (!$this->db->insert_batch('detail_header', $dataDetail)) {  //insert multie detail

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbHutang($po);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}

		//insert menggunakan DP berati insert tabel piutang kesuplayer
		if ($metode == 'Dp') {

			$datapiutang = array(

				'iduser' => $iduser,
				'idheader' => $po,
				'date' => $date,
				'idsuplayer' => $idsuplayer,
				'totalhutang' => $sisa,
				'kethutang' => 'Piutang',
			);
			if (!$this->db->insert('hutang', $datapiutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($po);
				$this->hapusDbDetail($po);
				$this->hapusDbHutang($po);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		// end insert piutang kesuplayer

		//cek hutang;
		if ($piutang > 0 && $pilihpiutang == 'yes') { //menyertakan pembayaran hutang

			if ($totalbayar >= $totalpembayaran) {  // jika nilai bayar lebih besar dari total pembayaran,
				// makan nilai bayar hutang adalah sama dengan nilai sisa piutang
				$nilaibayarhutang = $piutang;
				$sisahutang = 0;
				$kethutang = 'Lunas';
			} else {  //jika tidak lebih besar maka akan di ambil dari sisa pembayaran yang dilakukan

				$ceknilai	= $totalpembayaran - $piutang; //cek nilai totalpembayaran
				$nilaibayarhutang =  $totalbayar - $ceknilai;
				$sisahutang = $piutang - $nilaibayarhutang;
				$kethutang = 'Cicilan';
			}

			$databayarhutang = array(
				'iduser' => $iduser,
				'idheader' => $po,
				'date' => $date,
				'idsuplayer' => $idsuplayer,
				'bayarhutang' => $nilaibayarhutang,
				'sisahutang' => $sisahutang,
				'kethutang' => $kethutang,
			);


			if (!$this->db->insert('hutang', $databayarhutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($po);
				$this->hapusDbDetail($po);
				$this->hapusDbHutang($po);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		//end hutang

		echo json_encode(array('status' => true, 'ket' => 'Berhasil Di Perbaharui!'));
		die();
	}

	public function editPembelian()
	{
		if ($this->cekLevel()) {

			$notaPembelian = $this->input->post('idheader', true);
			$data['row'] = $this->db->select('*')->from('header')
				->join('user', 'user.iduser=header.iduser')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->where('header.idheader', $notaPembelian)
				->get()->row();

			$data['data'] = $this->db->where('idheader', $notaPembelian)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$ambilsuplayer = $this->db->where('idheader', $notaPembelian)->get('header')->row();
			$idsuplayer = $ambilsuplayer->idsuplayer;
			$data['piutang'] = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer', $idsuplayer)->where('idheader !=', $notaPembelian)->get()->row();
			$data['idsuplayer'] = $idsuplayer;
			$data['sp'] = $this->db->where('statussuplayer', 'On')->get('suplayer')->result();
			$this->load->view('admin/pembelian/editPembelian', $data);
		}
	}

	public function hapusPembelian()
	{
		if ($this->session->userdata('level') == 'admin') {
			$notaPembelian = $this->input->post('id', true);
			if (!$this->hapusDbHeader($notaPembelian)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbDetail($notaPembelian)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbHutang($notaPembelian)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			echo json_encode(array('status' => true, 'ket' => 'Data Berhasil Di Hapus!!!'));
			die();
		} else {

			echo json_encode(array('status' => false, 'ket' => 'Gagal! Tidak Memiliki Akses Untuk Menghapus!!'));
			die();
		}
	}

	public function hapusDbHeader($var)
	{

		return $this->db->delete('header', array('idheader' => $var));
	}
	public function hapusDbDetail($var)
	{

		return	$this->db->delete('detail_header', array('idheader' => $var));
	}
	public function hapusDbHutang($var)
	{

		return $this->db->delete('hutang', array('idheader' => $var));
	}
	public function cekPiutang()
	{

		$idsuplayer = $this->input->post('idsup', true);
		$data = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer', $idsuplayer)->get()->row();

		if (!empty($data)) {
			echo json_encode(array('status' => true, 'sisahutang' => $data->sisahutang));
		} else {
			echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan Mengambil Data Piutang!'));
		}
	}
	public function showHarga()
	{
		$t = $this->input->post('t', true);
		$l = $this->input->post('l', true);
		$p = $this->input->post('p', true);
		$idbarang = $t . $l . $p;
		$idsuplayer = $this->input->post('idsup', true);

		$ambilket = $this->db->select('header.idsuplayer,detail_header.idbarang, detail_header.hargam3, detail_header.ket, detail_header.date')->from('header')
			->join('detail_header', 'detail_header.idheader=header.idheader')
			->where('header.status', 'pmb')
			->where('detail_header.idbarang', $idbarang)
			->where('header.idsuplayer', $idsuplayer)
			->group_by('detail_header.ket')
			->get()->result();


		$data = array();
		foreach ($ambilket as $ket) {

			$data[] = $this->db->select('header.idsuplayer,detail_header.idbarang, detail_header.hargam3, detail_header.ket, detail_header.date')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pmb')
				->where('detail_header.idbarang', $idbarang)
				->where('header.idsuplayer', $idsuplayer)
				->where('detail_header.ket', $ket->ket)
				->order_by('detail_header.iddetail', 'DESC')
				->get()->row();
		}
		echo json_encode(array('status' => true, 'data' => $data));
	}
	public function printPembelian1($id)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {

			$suplayer = $this->db->where('idsuplayer', $header->idsuplayer)->get('suplayer')->row();
			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();
			//$ambilpiutang = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer',$header->idsuplayer)->where('idheader !=',$id)->get()->row();

			$hargatotalawal = $header->hargatotalawal;
			$piutang = $header->hutang;
			$pilihpiutang = $header->pilihhutang;
			$hargasetelahpiutang = $header->setelahhutang;
			$transport = $header->transport;
			$hargasetelahtransport = $header->hargasetelahtransport;
			$bongkar = $header->bongkar;
			$hargasetelahbongkar = $header->hargasetelahbongkar;
			$totalpembayaran = $header->totalharga;
			$bayar = $header->bayar;


			if ($pilihpiutang == 'yes') {

				$totalpembayaran = $totalpembayaran + $piutang;
				$sisa = ($totalpembayaran - $bayar);
			} else {
				$totalpembayaran = $totalpembayaran;
				$sisa = $header->sisa;
			}


			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;





			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(210, 297));
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 20);
			$pdf->Cell(12, 25, ' UD.BRILIAN', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(150, 6, '  Jl. Marga Bhakti Rt.03/01', 0, 0, 'L');
			$pdf->Cell(55, 6, $id, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Kel.Kertamaya, Kec.Bogor Selatan', 0, 0, 'L');
			$pdf->Cell(190, 6, 'Tanggal : ' . $header->date, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Kota Bogor, 16138', 0, 0, 'L');
			$pdf->Cell(190, 6, 'Suplayer, Bpk/Ibu : ' . $suplayer->namasuplayer, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Menjual Macam-Macam Kayu', 0, 0, 'L');
			$pdf->Cell(190, 6, $suplayer->alamatsuplayer, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(14, 6, '  (Mahoni, Bayur, Akor, Salam, Mindi DLL)', 0, 0, 'L');
			$pdf->Ln();
			$pdf->Cell(14, 6, '  Telp. 089637410775, 081213570707', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(30, 5, 'Kelompok', 1, '0', 'C', true);
			$pdf->Cell(10, 5, 'Pcs', 1, 0, 'C', true);
			$pdf->Cell(30, 5, 'Volume M3', 1, 0, 'C', true);
			$pdf->Cell(40, 5, 'Harga M3', 1, 0, 'C', true);
			$pdf->Cell(40, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(30, 5, 'Keterangan', 1, 0, 'C', true);
			$pdf->Cell(30, 5, 'Harga Satuan', 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(10, 5, 'T', 1, 0, 'C', true);
			$pdf->Cell(10, 5, 'L', 1, 0, 'C', true);
			$pdf->Cell(10, 5, 'P', 1, 0, 'C', true);
			$pdf->Cell(180, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);

			foreach ($detail_header as $tp) {
				$totalqty = $totalqty + $tp->qty;
				$totalm3 = $totalm3 + $tp->m3;
				$totalharga = $totalharga + $tp->totalharga;
				$pdf->Cell(10, 5, $tp->t, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->l, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->p, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->qty, 1, 0, 'C', true);
				$pdf->Cell(30, 5, $tp->m3, 1, 0, 'C', true);
				$pdf->Cell(40, 5, number_format($tp->hargam3), 1, 0, 'C', true);
				$pdf->Cell(40, 5, number_format($tp->totalharga), 1, 0, 'C', true);
				$pdf->Cell(30, 5, $tp->ket, 1, 0, 'C', true);
				$pdf->Cell(30, 5, number_format($tp->hargasatuan), 1, 0, 'C', true);
				$pdf->Ln();
			}
			$pdf->Ln();
			$pdf->Cell(30, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(30, 5, $totalm3, 1, 0, 'C', true);
			$pdf->Cell(40, 5, '', 1, 0, 'C', true);
			$pdf->Cell(40, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(30, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			if ($pilihpiutang == "yes") {
				$pdf->Cell(110, 5, 'Piutang ', 1, 0, 'R', true);
				$pdf->Cell(40, 5, number_format($piutang), 1, 0, 'C', true);
				$pdf->Cell(30, 5, number_format($hargasetelahpiutang), 1, 0, 'C', true);
				$pdf->Cell(30, 5, '', 1, 0, 'C', true);
				$pdf->Ln();
			}


			$pdf->Cell(110, 5, 'Bongkar ', 1, 0, 'R', true);
			$pdf->Cell(40, 5, number_format($bongkar), 1, 0, 'C', true);
			$pdf->Cell(30, 5, number_format($hargasetelahbongkar), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Ln();



			$pdf->Cell(110, 5, 'Trnasport ', 1, 0, 'R', true);
			$pdf->Cell(40, 5, number_format($transport), 1, 0, 'C', true);
			$pdf->Cell(30, 5, number_format($hargasetelahtransport), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Ln();



			$pdf->Cell(150, 5, 'Total Pembayaran ', 1, 0, 'R', true);
			$pdf->Cell(30, 5, number_format($totalpembayaran), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(150, 5, 'Bayar ', 1, 0, 'R', true);
			$pdf->Cell(30, 5, number_format($bayar), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(150, 5, 'Sisa ', 1, 0, 'R', true);
			$pdf->Cell(30, 5, number_format($sisa), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}
	public function printPembelian2($id)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {

			$suplayer = $this->db->where('idsuplayer', $header->idsuplayer)->get('suplayer')->row();
			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();
			//$ambilpiutang = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer',$header->idsuplayer)->where('idheader !=',$id)->get()->row();

			$hargatotalawal = $header->hargatotalawal;
			$piutang = $header->hutang;
			$pilihpiutang = $header->pilihhutang;
			$hargasetelahpiutang = $header->setelahhutang;
			$transport = $header->transport;
			$hargasetelahtransport = $header->hargasetelahtransport;
			$bongkar = $header->bongkar;
			$hargasetelahbongkar = $header->hargasetelahbongkar;
			$totalpembayaran = $header->totalharga;
			$bayar = $header->bayar;


			if ($pilihpiutang == 'yes') {

				$totalpembayaran = $totalpembayaran + $piutang;
				$sisa = ($totalpembayaran - $bayar);
			} else {
				$totalpembayaran = $totalpembayaran;
				$sisa = $header->sisa;
			}


			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;


			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(210, 297));
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 20);
			$pdf->Cell(12, 25, ' UD.BRILIAN', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(150, 6, '  Jl. Marga Bhakti Rt.03/01', 0, 0, 'L');
			$pdf->Cell(55, 6, $id, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Kel.Kertamaya, Kec.Bogor Selatan', 0, 0, 'L');
			$pdf->Cell(190, 6, 'Tanggal : ' . $header->date, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Kota Bogor, 16138', 0, 0, 'L');
			$pdf->Cell(190, 6, 'Suplayer, Bpk/Ibu : ' . $suplayer->namasuplayer, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(15, 6, '  Menjual Macam-Macam Kayu', 0, 0, 'L');
			$pdf->Cell(190, 6, $suplayer->alamatsuplayer, 0, 0, 'R');
			$pdf->Cell(5, 6, '', 0, 0, 'R');
			$pdf->Ln();
			$pdf->Cell(14, 6, '  (Mahoni, Bayur, Akor, Salam, Mindi DLL)', 0, 0, 'L');
			$pdf->Ln();
			$pdf->Cell(14, 6, '  Telp. 089637410775, 081213570707', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(30, 5, 'Kelompok', 1, '0', 'C', true);
			$pdf->Cell(10, 5, 'Pcs', 1, 0, 'C', true);
			$pdf->Cell(30, 5, 'Volume M3', 1, 0, 'C', true);
			$pdf->Cell(50, 5, 'Harga M3', 1, 0, 'C', true);
			$pdf->Cell(50, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(40, 5, 'Keterangan', 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(10, 5, 'T', 1, 0, 'C', true);
			$pdf->Cell(10, 5, 'L', 1, 0, 'C', true);
			$pdf->Cell(10, 5, 'P', 1, 0, 'C', true);
			$pdf->Cell(180, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);

			foreach ($detail_header as $tp) {
				$totalqty = $totalqty + $tp->qty;
				$totalm3 = $totalm3 + $tp->m3;
				$totalharga = $totalharga + $tp->totalharga;
				$pdf->Cell(10, 5, $tp->t, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->l, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->p, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->qty, 1, 0, 'C', true);
				$pdf->Cell(30, 5, $tp->m3, 1, 0, 'C', true);
				$pdf->Cell(50, 5, number_format($tp->hargam3), 1, 0, 'C', true);
				$pdf->Cell(50, 5, number_format($tp->totalharga), 1, 0, 'C', true);
				$pdf->Cell(40, 5, $tp->ket, 1, 0, 'C', true);
				$pdf->Ln();
			}
			$pdf->Ln();
			$pdf->Cell(30, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(30, 5, number_format($totalm3, 3), 1, 0, 'C', true);
			$pdf->Cell(50, 5, '', 1, 0, 'C', true);
			$pdf->Cell(50, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(40, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Ln();

			if ($pilihpiutang == "yes") {
				$pdf->Cell(120, 5, 'Piutang ', 1, 0, 'R', true);
				$pdf->Cell(50, 5, number_format($piutang), 1, 0, 'C', true);
				$pdf->Cell(40, 5, number_format($hargasetelahpiutang), 1, 0, 'C', true);
				$pdf->Ln();
			}


			$pdf->Cell(120, 5, 'Bongkar ', 1, 0, 'R', true);
			$pdf->Cell(50, 5, number_format($bongkar), 1, 0, 'C', true);
			$pdf->Cell(40, 5, number_format($hargasetelahbongkar), 1, 0, 'C', true);
			$pdf->Ln();


			$pdf->Cell(120, 5, 'Trnasport ', 1, 0, 'R', true);
			$pdf->Cell(50, 5, number_format($transport), 1, 0, 'C', true);
			$pdf->Cell(40, 5, number_format($hargasetelahtransport), 1, 0, 'C', true);
			$pdf->Ln();



			$pdf->Cell(170, 5, 'Total Pembayaran ', 1, 0, 'R', true);
			$pdf->Cell(40, 5, number_format($totalpembayaran), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(170, 5, 'Bayar ', 1, 0, 'R', true);
			$pdf->Cell(40, 5, number_format($bayar), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(170, 5, 'Sisa ', 1, 0, 'R', true);
			$pdf->Cell(40, 5, number_format($sisa), 1, 0, 'C', true);

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}



	public function liststokbarang($tinggi, $lebar, $panjang, $idbarang, $pcs, $subtotal, $po)
	{

		$t = $tinggi;
		$l = $lebar;
		$p = $panjang;
		$pcs = $pcs;
		$subtotal = $subtotal;
		$idbarang = $idbarang;
		$idheader = $po;

		$date_bln_sekarang = date('Y-m-d');
		$date_bln_kemarin = date('Y-m', strtotime('-1 month', strtotime($date_bln_sekarang)));
		//data masuk
		$data_qty_m_k = $this->db->select('*')->from('liststokbarang')->where('status', 'pmb')->where('idbarang', $idbarang)->like('date', $date_bln_kemarin)->order_by('idliststok', 'desc')->get()->row();
		$qty_m_k = (!empty($data_qty_m_k->qty) ? $data_qty_m_k->qty : 0);
		$qty_m_nominal = (!empty($data_qty_m_k->nominal) ? $data_qty_m_k->nominal : 0);
		//data keluar
		$qty_k_k = $this->db->select('SUM(qty) as qty_keluar')->from('liststokbarang')->where('status', 'pnj')->where('idbarang', $idbarang)->like('date', $date_bln_kemarin)->get()->row();
		$qty_k_k = (!empty($qty_k_k->qty_keluar) ? $qty_k_k->qty_keluar : 0);

		//data menacri sisa stok 
		$sisa_qty_bln_kemarin = ($qty_m_k - $qty_k_k);
		$nominal_bln_kemarin = $qty_m_nominal;
		$total_nominal_bln_kemarin = $sisa_qty_bln_kemarin * $nominal_bln_kemarin;
		//end stok sisa kemarin

		echo var_dump($sisa_qty_bln_kemarin);
		die();


		//qty_masuk bulan sekarng 
		$bln_berjalan = $this->db->select('SUM(detail_header.qty) as qty_masuk, SUM(detail_header.totalharga) as totalharga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pmb')->where('detail_header.idbarang', $idbarang)->like('header.date', date('Y-m'))->get()->row();
		$qty_masuk_bln_berjalan = (!empty($bln_berjalan->qty_masuk) ? $bln_berjalan->qty_masuk : 0);
		$total_nominal_bln_berjalan = (!empty($bln_berjalan->totalharga) ? $bln_berjalan->totalharga : 0);
		$nominal_bln_berjalan = (!empty($bln_berjalan->totalharga) ? ($total_nominal_bln_berjalan / $qty_masuk_bln_berjalan) : 0);

		//gabung qty_masuk bln berjalan dan sisa qty bln kemarin;

		$qty_g = $sisa_qty_bln_kemarin + $qty_masuk_bln_berjalan;
		$total_nominal_g = $total_nominal_bln_kemarin + $total_nominal_bln_berjalan;
		$nominal_g = (!empty($total_nominal_g) ? ($total_nominal_g / $qty_g) : 0);


		//data yang akan masuk sekarang
		$qty_s = $pcs;
		$total_nominal_s = $subtotal;



		//gabung dengan data yang akan masuk;
		$qty_i = $qty_s + $qty_g;
		$total_nominal_i = $total_nominal_s + $total_nominal_g;
		$nominal_i = $total_nominal_i / $qty_i;

		//input data list stok terbaru
		$data =  array(
			'idheader' => $idheader,
			'status' => 'pmb',
			'date' => date('Y-m-d'),
			'idbarang' => $idbarang,
			't' => $t,
			'l' => $l,
			'p' => $p,
			'qty' => $qty_i,
			'nominal' => $nominal_i,
		);

		if (!empty($this->db->insert('liststokbarang', $data))) {
			return true;
		} else {
			echo "Gagal";
			die();
		}
	}
}
