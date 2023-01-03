<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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

		$dateSebelum = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));
		$dateNow = date('Y-m-d');

		$tglP = empty($tglP) ? $dateSebelum : $tglP;
		$tglK = empty($tglK) ? $dateNow : $tglK;


		$data['tglP'] = $tglP;
		$data['tglK'] = $tglK;


		$data['data'] = $this->db->select()->from('header')
			->join('user', 'user.iduser=header.iduser')
			->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
			->where('header.status', 'pnj')
			->where('header.date >=', $tglP)
			->where('header.date <=', $tglK)
			->order_by('idheader', 'desc')
			->get()->result();
		$this->load->view('admin/penjualan/index', $data);
	}

	public function kodeInvoice()
	{

		$iduser =  $this->session->userdata('iduser');
		$ambil = $this->db->select('MAX(RIGHT(idheader,3)) as invoice')->from('header')->where('date', date('Y-m-d'))->where('iduser', $iduser)->where('status', 'pnj')->get()->row();
		if (empty($ambil)) {
			$invoice = 'SO' . date('Ymd') . $iduser . '001';
		} else {
			$kodeB = (int)$ambil->invoice + 1;
			$invoice = 'SO' . date('Ymd') . $iduser . sprintf("%03s", $kodeB);
		}

		return $invoice;
	}



	public function addPenjualan()
	{

		$cek = $this->db->where_in('status', array('berhasil', 'Stock Opname'))->like('tanggal', date('Y-m'))->get('sinkronstok')->num_rows();
		if ($cek > 0) {

			$iduser =  $this->session->userdata('iduser');
			$ambil = $this->db->select('MAX(RIGHT(idheader,3)) as invoice')->from('header')->where('date', date('Y-m-d'))->where('iduser', $iduser)->where('status', 'pnj')->get()->row();
			if (empty($ambil)) {
				$invoice = 'SO' . date('Ymd') . $iduser . '001';
			} else {
				$kodeB = (int)$ambil->invoice + 1;
				$invoice = 'SO' . date('Ymd') . $iduser . sprintf("%03s", $kodeB);
			}

			$data['so'] = $invoice;
			$data['user'] = $iduser;
			$data['pl'] = $this->db->where('statuspelanggan', 'On')->get('pelanggan')->result();
			$this->load->view('admin/penjualan/addPenjualan', $data);
		} else {
			// jika verifikasi blm dilakukan masuk kemenu ini.
			echo $this->session->set_flashdata("massage", "<script> alert('Lakukan Proses Sinkron atau Verifikasi terlebih dahulu!!!')</script>");
			redirect(base_url('admin/Barang/sinkronStok'));
		}
	}

	public function simpanPenjualan()
	{

		$so = $this->input->post('so', true);
		$iduser = $this->input->post('user', true);
		$date = $this->input->post('date', true);
		$idcus = $this->input->post('idpelanggan', true);

		$cekSo = $this->db->where('idheader', $so)->get('header')->num_rows();
		if ($cekSo > 0) { //jika ada SO yg masuk dan di simpan kembali maka yg sebulmnya di hapus dulu

			//hapus inputan pertama
			if (!$this->hapusDbHeader($so)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
			if (!$this->hapusDbDetail($so)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
			if (!$this->hapusDbHutang($so)) {
				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
				die();
			}
		}




		$totalawal = str_replace(',', '', $this->input->post('totalsubtotal', true));
		$hutang = str_replace(',', '', $this->input->post('hutang', true));
		$pilihhutang = $this->input->post('pilihhutang', true);
		$setelahhutang = str_replace(',', '', $this->input->post('totalsetelahhutang', true));
		$diskon = str_replace(',', '', $this->input->post('diskon', true));
		$setelahdiskon = str_replace(',', '', $this->input->post('totalsetelahdiskon', true));
		$totalpembayaran = str_replace(',', '', $this->input->post('totalpembayaran', true));
		$metode = $this->input->post('metode', true);
		$totalbayar =  str_replace(',', '', $this->input->post('totalbayar', true));
		$sisa = str_replace(',', '', $this->input->post('sisa', true));







		if (!$this->db->where('idpelanggan', $idcus)->get('pelanggan')->row()) //cek apakah custamer terdaftar jika tida gagal
		{
			echo json_encode(array('status' => false, 'ket' => 'Cusatmer Belum Terdafatar, Daftarkan Terlebih Dulu!'));
			die();
		}

		if ($metode == 'Dp' && $totalbayar >= $totalpembayaran) {
			echo json_encode(array('status' => false, 'ket' => 'DP (Pembayaran tidak boleh lebih besar atau sama dengan Total Pembayaran)!'));
			die();
		}

		if ($metode == 'Tunai' && $pilihhutang == 'yes') {

			$pembayaranSebelumnnya	= $totalpembayaran - $hutang; //cek nilai totalpembayaran
			//jika metode tunai dan menyertakan ingin membayar hutang maka totalbayar tidak boleh kurang atau sama dengan teransaksi yang akan dilakukan
			if ($totalbayar <= $pembayaranSebelumnnya) {
				echo json_encode(array('status' => false, 'ket' => 'Penyertaan Hutang (Pembayaran tidak boleh lebih kecil atau sama dengan Total Pembayaran)!'));
				die();
			}
		} else if ($metode == 'Tunai' && $pilihhutang == 'no') {

			if ($metode == 'Tunai' && $totalbayar < $totalpembayaran) {
				echo json_encode(array('status' => false, 'ket' => 'Tunai (Pembayaran tidak boleh lebih kecil dari Total Pembayaran)!'));
				die();
			}
		}

		if ($pilihhutang == 'yes' && $metode == 'Dp' or $hutang > 0 && $metode == 'Dp') {
			echo json_encode(array('status' => false, 'ket' => 'Pembayaran tidak dapat dilakukan DP, Terkendala dengan adanya Hutang, Gunakan Tunai!'));
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
			$hargamodal = str_replace(',', '', $_POST['hargamodal'][$i]);
			$hargasatuan = str_replace(',', '', $_POST['harga'][$i]);
			$subtotal = str_replace(',', '', $_POST['subtotal'][$i]);
			$ket = $_POST['ket'][$i];
			$kodebarang = $t . $l . $p;

			if ($this->cekStokServer($t, $l, $p, $pcs, $i) == true) //cek persatu stok;


				if ($m3 == 'NaN') {
					echo json_encode(array('status' => false, 'ket' => 'Inputan ada yang tidak sesuai harap priksa kembali!'));
					die();
				} else if ($t > '0' && $l > '0' && $p > '0' && $m3 == '0') {
					echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan, Pcs dan Harga M3!'));
					die();
				} else if ($t > '0' && $l > '0' && $p > '0' && $pcs > 0 && $hargasatuan == '0') {
					echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan Harga M3!'));
					die();
				} else if ($pcs != '0' && $m3 != '0') {

					$dataDetail[] = array(
						'idheader' => $so,
						'date' => $date,
						'idbarang' => $kodebarang,
						't' => $t,
						'l' => $l,
						'p' => $p,
						'qty'	=> $pcs,
						'm3' => $m3,
						'hargamodal' => $hargamodal,
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
		if ($metode == 'Tunai' && $pilihhutang == 'no') {

			$totalHarga = $totalpembayaran;
			$sisa = '0';
		}
		if ($metode == 'Tunai' && $pilihhutang == 'yes') {

			$totalHarga = $totalpembayaran - $hutang;
			$sisa = '0';
		}


		$dataHeader = array(
			'idheader' => $so,
			'iduser' => $iduser,
			'date' => $date,
			'idpelanggan' => $idcus,
			'status' => 'pnj', //pmb artinya Penjualan
			'hargatotalawal' => $totalawal,
			'hutang' => $hutang,
			'pilihhutang' => $pilihhutang,
			'setelahhutang' => $setelahhutang,
			'diskon' => $diskon,
			'hargasetelahdiskon' => $setelahdiskon,
			'totalharga' => $totalHarga,
			'metodebayar' => $metode,
			'bayar' => $totalbayar,
			'sisa' => $sisa,
		);
		if (!$this->db->insert('header', $dataHeader)) {

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($so);
			$this->hapusDbDetail($so);
			$this->hapusDbHutang($so);
			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}


		//insert detail

		if (!$this->db->insert_batch('detail_header', $dataDetail)) {  //insert multie detail

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($so);
			$this->hapusDbDetail($so);
			$this->hapusDbHutang($so);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}

		//insert menggunakan DP berati insert tabel pihutang kesuplayer
		if ($metode == 'Dp') {

			$datahutang = array(

				'iduser' => $iduser,
				'idheader' => $so,
				'date' => $date,
				'idpelanggan' => $idcus,
				'totalhutang' => $sisa,
				'kethutang' => 'Hutang',
			);
			if (!$this->db->insert('hutang', $datahutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($so);
				$this->hapusDbDetail($so);
				$this->hapusDbHutang($so);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		// end insert hutang kesuplayer

		//cek hutang;
		if ($hutang > 0 && $pilihhutang == 'yes') { //menyertakan pembayaran hutang

			if ($totalbayar >= $totalpembayaran) {  // jika nilai bayar lebih besar dari total pembayaran,
				// makan nilai bayar hutang adalah sama dengan nilai sisa hutang
				$nilaibayarhutang = $hutang;
				$sisahutang = 0;
				$kethutang = "Lunas";
			} else {  //jika tidak lebih besar maka akan di ambil dari sisa pembayaran yang dilakukan

				$ceknilai	= $totalpembayaran - $hutang; //cek nilai totalpembayaran
				$nilaibayarhutang =  $totalbayar - $ceknilai;
				$sisahutang = $hutang - $nilaibayarhutang;
				$kethutang = "Cicilan";
			}

			$databayarhutang = array(
				'iduser' => $iduser,
				'idheader' => $so,
				'date' => $date,
				'idpelanggan' => $idcus,
				'bayarhutang' => $nilaibayarhutang,
				'sisahutang' => $sisahutang,
				'kethutang' => $kethutang,
			);

			if (!$this->db->insert('hutang', $databayarhutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($so);
				$this->hapusDbDetail($so);
				$this->hapusDbHutang($so);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		//end hutang

		echo json_encode(array('status' => true, 'ket' => 'Transaksi Berhasil Di Simpan!'));
		die();
	}

	public function listPenjualan()
	{

		$data['data'] = $this->db->select()->from('header')
			->join('user', 'user.iduser=header.iduser')
			->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
			->where('header.status', 'pnj')
			->order_by('idheader', 'desc')
			->get()->result();
		$this->load->view('admin/penjualan/listPenjualan', $data);
	}

	public function detailPenjualan($notaPenjualan = null)
	{

		if (!empty($notaPenjualan)) {
			$data['row'] = $this->db->select('*')->from('header')
				->join('user', 'user.iduser=header.iduser')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->where('header.idheader', $notaPenjualan)
				->get()->row();

			$data['data'] = $this->db->where('idheader', $notaPenjualan)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$this->load->view('admin/penjualan/detailPenjualan', $data);
		}
	}

	public function updatePenjualan()
	{

		$so = $this->input->post('so', true);
		$iduser = $this->input->post('user', true);
		$date = $this->input->post('date', true);
		$idcus = $this->input->post('idpelanggan', true);

		$totalawal = str_replace(',', '', $this->input->post('totalsubtotal', true));
		$hutang = str_replace(',', '', $this->input->post('hutang', true));
		$pilihhutang = $this->input->post('pilihhutang', true);
		$setelahhutang = str_replace(',', '', $this->input->post('totalsetelahhutang', true));
		$diskon = str_replace(',', '', $this->input->post('diskon', true));
		$setelahdiskon = str_replace(',', '', $this->input->post('totalsetelahdiskon', true));
		$totalpembayaran = str_replace(',', '', $this->input->post('totalpembayaran', true));
		$metode = $this->input->post('metode', true);
		$totalbayar =  str_replace(',', '', $this->input->post('totalbayar', true));
		$sisa = str_replace(',', '', $this->input->post('sisa', true));


		if (!$this->db->where('idpelanggan', $idcus)->get('pelanggan')->row()) //cek apakah custamer terdaftar jika tida gagal
		{
			echo json_encode(array('status' => false, 'ket' => 'Cusatmer Belum Terdafatar, Daftarkan Terlebih Dulu!'));
			die();
		}


		if ($metode == 'Dp' && $totalbayar >= $totalpembayaran) {
			echo json_encode(array('status' => false, 'ket' => 'DP (Pembayaran tidak boleh lebih besar atau sama dengan Total Pembayaran)!'));
			die();
		}

		if ($metode == 'Tunai' && $pilihhutang == 'yes') {

			$pembayaranSebelumnnya	= $totalpembayaran - $hutang; //cek nilai totalpembayaran
			//jika metode tunai dan menyertakan ingin membayar hutang maka totalbayar tidak boleh kurang atau sama dengan teransaksi yang akan dilakukan
			if ($totalbayar <= $pembayaranSebelumnnya) {
				echo json_encode(array('status' => false, 'ket' => 'Penyertaan Hutang (Pembayaran tidak boleh lebih kecil atau sama dengan Total Pembayaran)!'));
				die();
			}
		} else if ($metode == 'Tunai' && $pilihhutang == 'no') {

			if ($metode == 'Tunai' && $totalbayar < $totalpembayaran) {
				echo json_encode(array('status' => false, 'ket' => 'Tunai (Pembayaran tidak boleh lebih kecil dari Total Pembayaran)!'));
				die();
			}
		}

		if ($pilihhutang == 'yes' && $metode == 'Dp' or $hutang > 0 && $metode == 'Dp') {
			echo json_encode(array('status' => false, 'ket' => 'Pembayaran tidak dapat dilakukan DP, Terkendala dengan adanya Hutang, Gunakan Tunai!'));
			die();
		}

		//hapus inputan pertama
		if (!$this->hapusDbHeader($so)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
			die();
		}
		if (!$this->hapusDbDetail($so)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
			die();
		}
		if (!$this->hapusDbHutang($so)) {
			echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Perubahan, Terjadi kesalahan sistem!'));
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
			$hargamodal = str_replace(',', '', $_POST['hargamodal'][$i]);
			$hargasatuan = str_replace(',', '', $_POST['harga'][$i]);
			$subtotal = str_replace(',', '', $_POST['subtotal'][$i]);
			$ket = $_POST['ket'][$i];
			$kodebarang = $t . $l . $p;


			if ($this->cekStokServer($t, $l, $p, $pcs, $i) == true) //cek persatu stok;

				if ($m3 == 'NaN') {
					echo json_encode(array('status' => false, 'ket' => 'Inputan ada yang tidak sesuai harap priksa kembali!'));
					die();
				} else if ($t > '0' && $l > '0' && $p > '0' && $m3 == '0') {
					echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan, Pcs dan Harga M3!'));
					die();
				} else if ($t > '0' && $l > '0' && $p > '0' && $pcs > 0 && $hargasatuan == '0') {
					echo json_encode(array('status' => false, 'ket' => 'Harap Lengkapi Inputan Harga M3!'));
					die();
				} else if ($pcs != '0' && $m3 != '0') {

					$dataDetail[] = array(
						'idheader' => $so,
						'date' => $date,
						'idbarang' => $kodebarang,
						't' => $t,
						'l' => $l,
						'p' => $p,
						'qty'	=> $pcs,
						'm3' => $m3,
						'hargamodal' => $hargamodal,
						'totalharga' => $subtotal,
						'hargasatuan' => $hargasatuan,
						'ket' => ucwords($ket),
					);
				}
		}



		if ($metode == 'Dp') {

			$totalHarga = $totalpembayaran;
			$sisa = $sisa;
		}
		if ($metode == 'Tunai' && $pilihhutang == 'no') {

			$totalHarga = $totalpembayaran;
			$sisa = '0';
		}
		if ($metode == 'Tunai' && $pilihhutang == 'yes') {

			$totalHarga = $totalpembayaran - $hutang;
			$sisa = '0';
		}


		$dataHeader = array(
			'idheader' => $so,
			'iduser' => $iduser,
			'date' => $date,
			'idpelanggan' => $idcus,
			'status' => 'pnj', //pmb artinya Penjualan
			'hargatotalawal' => $totalawal,
			'hutang' => $hutang,
			'pilihhutang' => $pilihhutang,
			'setelahhutang' => $setelahhutang,
			'diskon' => $diskon,
			'hargasetelahdiskon' => $setelahdiskon,
			'totalharga' => $totalHarga,
			'metodebayar' => $metode,
			'bayar' => $totalbayar,
			'sisa' => $sisa,
		);
		if (!$this->db->insert('header', $dataHeader)) {

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($so);
			$this->hapusDbDetail($so);
			$this->hapusDbHutang($so);
			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}


		//insert detail

		if (!$this->db->insert_batch('detail_header', $dataDetail)) {  //insert multie detail

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($so);
			$this->hapusDbDetail($so);
			$this->hapusDbHutang($so);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}

		//insert menggunakan DP berati insert tabel hutang
		if ($metode == 'Dp') {

			$datahutang = array(

				'iduser' => $iduser,
				'idheader' => $so,
				'date' => $date,
				'idpelanggan' => $idcus,
				'totalhutang' => $sisa,
				'kethutang' => 'Hutang',
			);
			if (!$this->db->insert('hutang', $datahutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($so);
				$this->hapusDbDetail($so);
				$this->hapusDbHutang($so);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		// end insert hutang kesuplayer

		//cek hutang;
		if ($hutang > 0 && $pilihhutang == 'yes') { //menyertakan pembayaran hutang

			if ($totalbayar >= $totalpembayaran) {  // jika nilai bayar lebih besar dari total pembayaran,
				// makan nilai bayar hutang adalah sama dengan nilai sisa hutang
				$nilaibayarhutang = $hutang;
				$sisahutang = 0;
				$kethutang = "Lunas";
			} else {  //jika tidak lebih besar maka akan di ambil dari sisa pembayaran yang dilakukan

				$ceknilai	= $totalpembayaran - $hutang; //cek nilai totalpembayaran
				$nilaibayarhutang =  $totalbayar - $ceknilai;
				$sisahutang = $hutang - $nilaibayarhutang;
				$kethutang = "Cicilan";
			}

			$databayarhutang = array(
				'iduser' => $iduser,
				'idheader' => $so,
				'date' => $date,
				'idpelanggan' => $idcus,
				'bayarhutang' => $nilaibayarhutang,
				'sisahutang' => $sisahutang,
				'kethutang' => $kethutang,
			);

			if (!$this->db->insert('hutang', $databayarhutang)) {

				//jika error maka akan menghapus inputan yg lain
				$this->hapusDbHeader($so);
				$this->hapusDbDetail($so);
				$this->hapusDbHutang($so);
				echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
				die();
			};
		}
		//end hutang



		echo json_encode(array('status' => true, 'ket' => 'Transaksi Berhasil Di Perbaharui!'));
		die();
	}

	public function editPenjualan()
	{
		if ($this->cekLevel()) {

			$notaPenjualan = $this->input->post('idheader', true);
			$data['row'] = $this->db->select('*')->from('header')
				->join('user', 'user.iduser=header.iduser')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->where('header.idheader', $notaPenjualan)
				->get()->row();

			$data['data'] = $this->db->where('idheader', $notaPenjualan)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$ambilpelanggan = $this->db->where('idheader', $notaPenjualan)->get('header')->row();
			$idpelanggan = $ambilpelanggan->idpelanggan;
			$data['hutang'] = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idpelanggan', $idpelanggan)->where('idheader !=', $notaPenjualan)->get()->row();
			$data['idpelanggan'] = $idpelanggan;
			$data['cs'] = $this->db->where('statuspelanggan', 'On')->get('pelanggan')->result();
			$this->load->view('admin/penjualan/editPenjualan', $data);
		}
	}


	public function hapusPenjualan()
	{
		if ($this->session->userdata('level') == 'admin') {
			$nota = $this->input->post('id', true);
			if (!$this->hapusDbHeader($nota)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbDetail($nota)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbHutang($nota)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			echo json_encode(array('status' => true, 'ket' => 'Data Berhasil Di Hapus!!!'));
			die();
		} else {

			echo json_encode(array('status' => false, 'ket' => 'Gagal! Anda Tidak Memiliki Akses Untuk Hapus!!!'));
			die();
		}
	}





	public function getNotaPenjualan()
	{
		$iduser =  $_GET['iduser'];
		$ambil = $this->db->select('MAX(RIGHT(idheader,3)) as invoice')->from('header')->where('date', date('Y-m-d'))->where('iduser', $iduser)->where('status', 'pnj')->get()->row();
		if (empty($ambil)) {
			$invoice = 'SO' . date('Ymd') . $iduser . '001';
		} else {
			$kodeB = (int)$ambil->invoice + 1;
			$invoice = 'SO' . date('Ymd') . $iduser . sprintf("%03s", $kodeB);
		}

		echo json_encode(array('status' => true, 'notaPenjualan' => $invoice));
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

	public function cekHutang()
	{

		$idcus = $this->input->post('idcus', true);
		$data = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idpelanggan', $idcus)->get()->row();

		if (!empty($data)) {
			echo json_encode(array('status' => true, 'sisahutang' => $data->sisahutang));
		} else {
			echo json_encode(array('status' => false, 'ket' => 'Terjadi Kesalahan Mengambil Data hutang!'));
		}
	}

	public function cekStokPop($idbarang, $pcs)
	{

		$idbarang = $idbarang;
		$pcs = $pcs;
		$dateNow = date('Y-m-d');

		//cek apakah ada stock opname dibulan ini
		//jika ada perhitungan di mulai tgl stock opname

		$kode = "STOCKOPNAME" . date('Ym',strtotime($dateNow));;
		$cek = $this->db->where('idheader', $kode)->get('header')->row();
		if (!empty($cek)) {

			$dateMulai = $cek->date;

		} else {

			$dateMulai = date('Y-m')."-01";
		}



		$masuk = $this->db->select('SUM(detail_header.qty) as qty, SUM(detail_header.totalharga) as harga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status !=', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();
		$keluar = $this->db->select('SUM(detail_header.qty) as qty')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();


		if ($idbarang == '000') {
			echo json_encode(array('status' => true, 'ket' => 'success'));
			die();
		} else {

			if (!empty($masuk)) {
				$stok = ((int)$masuk[0]['qty']) - (!empty($keluar[0]['qty']) ? (int)$keluar[0]['qty'] : 0);
				if ($pcs > $stok) {
					echo json_encode(array('status' => false, 'ket' => 'Jumlah Pcs Melebihi Persediaan!'));
					die();
				} else {
					$hargamodal = (int)$masuk[0]['harga'] / (!empty($masuk[0]['qty']) ? (int)$masuk[0]['qty'] : 0);
					echo json_encode(array('status' => true, 'ket' => 'success', 'hargamodal' => round($hargamodal)));
					die();
				}
			} else {
				echo json_encode(array('status' => false, 'ket' => 'Periksa Kembali, Barang tidak tersedia!'));
				die();
			}
		}
	}


	public function cekStok($tinggi, $lebar, $panjang, $pcsj)
	{

		$t = $tinggi;
		$l = $lebar;
		$p = $panjang;
		$pcs = $pcsj;
		$idbarang = $t . $l . $p;

		$dateNow = date('Y-m-d');

		//cek apakah ada stock opname dibulan ini
		//jika ada perhitungan di mulai tgl stock opname

		$kode = "STOCKOPNAME" . date('Ym',strtotime($dateNow));;
		$cek = $this->db->where('idheader', $kode)->get('header')->row();
		if (!empty($cek)) {

			$dateMulai = $cek->date;

		} else {

			$dateMulai = date('Y-m')."-01";
		}



		$masuk = $this->db->select('SUM(detail_header.qty) as qty, SUM(detail_header.totalharga) as harga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status !=', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();
		$keluar = $this->db->select('SUM(detail_header.qty) as qty')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();


		if ($idbarang == '000') {
			echo json_encode(array('status' => true, 'ket' => 'success'));
			die();
		} else {

			if (!empty($masuk)) {
				$stok = ((int)$masuk[0]['qty']) - (!empty($keluar[0]['qty']) ? (int)$keluar[0]['qty'] : 0);
				if ($pcs > $stok) {
					echo json_encode(array('status' => false, 'ket' => 'Jumlah Pcs Melebihi Persediaan!'));
					die();
				} else {
					$hargamodal = (int)$masuk[0]['harga'] / (!empty($masuk[0]['qty']) ? (int)$masuk[0]['qty'] : 0);
					echo json_encode(array('status' => true, 'ket' => 'success', 'hargamodal' => round($hargamodal)));
					die();
				}
			} else {
				echo json_encode(array('status' => false, 'ket' => 'Periksa Kembali, Barang tidak tersedia!'));
				die();
			}
		}
	}

	public function cekStokServer($tinggi, $lebar, $panjang, $pcsj, $no)
	{

		$t = $tinggi;
		$l = $lebar;
		$p = $panjang;
		$pcs = $pcsj;
		$idbarang = $t . $l . $p;
		$angka = $no + 1;

		$dateNow = date('Y-m-d');

		//cek apakah ada stock opname dibulan ini
		//jika ada perhitungan di mulai tgl stock opname

		$kode = "STOCKOPNAME" . date('Ym',strtotime($dateNow));;
		$cek = $this->db->where('idheader', $kode)->get('header')->row();
		if (!empty($cek)) {

			$dateMulai = $cek->date;

		} else {

			$dateMulai = date('Y-m')."-01";
		}
		

		$masuk = $this->db->select('SUM(detail_header.qty) as qty, SUM(detail_header.totalharga) as harga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status !=', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();
		$keluar = $this->db->select('SUM(detail_header.qty) as qty')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', date('Y-m'))->group_by('detail_header.idbarang')->get()->result_array();

		if ($idbarang == '0000' or $pcs == '0') {
			return true;
		} else {

			if (!empty($masuk)) {
				$stok = ((int)$masuk[0]['qty']) - (!empty($keluar[0]['qty']) ? (int)$keluar[0]['qty'] : 0);

				if ($pcs > $stok) {
					echo json_encode(array('status' => false, 'ket' => 'No ' . $angka . ' Jumlah Pcs Melebihi Persediaan!'));
					die();
				} else {
					return true;
				}
			} else {
				echo json_encode(array('status' => false, 'ket' => 'No ' . $angka . ' Periksa Kembali, Barang tidak tersedia!'));
				die();
			}
		}
	}

	public function showHarga()
	{

		$t = $this->input->post('t', true);
		$l = $this->input->post('l', true);
		$p = $this->input->post('p', true);
		$idbarang = $t . $l . $p;
		$idpelanggan = $this->input->post('idcust', true);

		$ambilket = $this->db->select('detail_header.ket')->from('header')
			->join('detail_header', 'detail_header.idheader=header.idheader')
			->where('header.status', 'pnj')
			->where('detail_header.idbarang', $idbarang)
			->where('header.idpelanggan', $idpelanggan)
			->group_by('detail_header.ket')->get()->result();

		$data = array();
		foreach ($ambilket as $ket) {
			$data[] = $this->db->select('detail_header.iddetail, detail_header.idbarang, detail_header.hargasatuan, detail_header.ket, detail_header.date')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pnj')
				->where('detail_header.idbarang', $idbarang)
				->where('header.idpelanggan', $idpelanggan)
				->where('detail_header.ket', $ket->ket)
				->order_by('detail_header.iddetail', 'DESC')
				->get()->row();
		}



		echo json_encode(array('status' => true, 'data' => $data));
	}




	public function printPenjualan1($id = null)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {

			$pelanggan = $this->db->where('idpelanggan', $header->idpelanggan)->get('pelanggan')->row();
			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$hargatotalawal = $header->hargatotalawal;
			$hutang = $header->hutang;
			$pilihhutang = $header->pilihhutang;
			$hargasetelahhutang = $header->setelahhutang;
			$diskon = $header->diskon;
			$hargasetelahdiskon = $header->hargasetelahdiskon;
			$totalpembayaran = $header->totalharga;
			$bayar = $header->bayar;


			if ($pilihhutang == 'yes') {

				$totalpembayaran = $totalpembayaran + $hutang;
				$sisa = ($totalpembayaran - $bayar);
			} else {
				$totalpembayaran = $totalpembayaran;
				$sisa = $header->sisa;
			}

			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;

			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(100, 210));
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(6, 8, ' UD.BRILIAN', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(70, 4, '  Jl. Marga Bhakti Rt.03/01', 0, 0, 'L');
			$pdf->Cell(28, 4, $id, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(6, 4, '  Kel.Kertamaya, Kec.Bogor Selatan', 0, 0, 'L');
			$pdf->Cell(92, 4, 'Tanggal : ' . $header->date, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(6, 4, '  Kota Bogor, 16138', 0, 0, 'L');
			$pdf->Cell(92, 4, 'Kepada, Bpk/Ibu : ' . $pelanggan->namapelanggan, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');

			$pdf->Ln();
			$pdf->Cell(6, 4, '  Menjual Macam-Macam Kayu', 0, 0, 'L');
			$pdf->Cell(92, 4, $pelanggan->alamatpelanggan, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(7, 4, '  (Mahoni, Bayur, Akor, Salam, Mindi DLL)', 0, 0, 'L');
			$pdf->Ln();
			$pdf->Cell(7, 4, '  Telp. 089637410775, 081213570707', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 7);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(24, 4, 'Ukran Kayu', 1, '0', 'C', true);
			$pdf->Cell(10, 4, 'Pcs', 1, 0, 'C', true);
			$pdf->Cell(15, 4, 'Harga', 1, 0, 'C', true);
			$pdf->Cell(15, 4, 'M3', 1, 0, 'C', true);
			$pdf->Cell(21, 4, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(15, 4, 'Keterangan', 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(8, 4, 'T', 1, 0, 'C', true);
			$pdf->Cell(8, 4, 'L', 1, 0, 'C', true);
			$pdf->Cell(8, 4, 'P', 1, 0, 'C', true);
			$pdf->Cell(76, 4, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 8);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);

			foreach ($detail_header as $tp) {
				$totalqty = $totalqty + $tp->qty;
				$totalm3 = $totalm3 + $tp->m3;
				$totalharga = $totalharga + $tp->totalharga;
				$pdf->Cell(8, 5, $tp->t, 1, 0, 'C', true);
				$pdf->Cell(8, 5, $tp->l, 1, 0, 'C', true);
				$pdf->Cell(8, 5, $tp->p, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->qty, 1, 0, 'C', true);
				$pdf->Cell(15, 5, number_format($tp->hargasatuan), 1, 0, 'C', true);
				$pdf->Cell(15, 5, $tp->m3, 1, 0, 'C', true);
				$pdf->Cell(21, 5, number_format($tp->totalharga), 1, 0, 'C', true);
				$pdf->Cell(15, 5, $tp->ket, 1, 0, 'C', true);
				$pdf->Ln();
			}
			$pdf->Cell(24, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(15, 5, number_format($tp->hargasatuan), 1, 0, 'C', true);
			$pdf->Cell(15, 5, $totalm3, 1, 0, 'C', true);
			$pdf->Cell(21, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(15, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			if ($pilihhutang == 'yes') {
				$pdf->Cell(64, 5, 'Hutang ', 1, 0, 'R', true);
				$pdf->Cell(21, 5, number_format($hutang), 1, 0, 'C', true);
				$pdf->Cell(15, 5, number_format($hargasetelahhutang), 1, 0, 'C', true);
				$pdf->Ln();
			}
			if (!empty($diskon)) {
				$pdf->Cell(64, 5, 'Diskon ', 1, 0, 'R', true);
				$pdf->Cell(21, 5, number_format($diskon), 1, 0, 'C', true);
				$pdf->Cell(15, 5, number_format($hargasetelahdiskon), 1, 0, 'C', true);
				$pdf->Ln();
			}

			$pdf->Cell(85, 5, 'Total Pembayaran ', 1, 0, 'R', true);
			$pdf->Cell(15, 5, number_format($totalpembayaran), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(85, 5, 'Bayar ', 1, 0, 'R', true);
			$pdf->Cell(15, 5, number_format($bayar), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(85, 5, 'Sisa ', 1, 0, 'R', true);
			$pdf->Cell(15, 5, number_format($sisa), 1, 0, 'C', true);

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}



	public function printPenjualan2($id = null)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {
			$pelanggan = $this->db->where('idpelanggan', $header->idpelanggan)->get('pelanggan')->row();
			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();

			$hargatotalawal = $header->hargatotalawal;
			$hutang = $header->hutang;
			$pilihhutang = $header->pilihhutang;
			$hargasetelahhutang = $header->setelahhutang;
			$diskon = $header->diskon;
			$hargasetelahdiskon = $header->hargasetelahdiskon;
			$totalpembayaran = $header->totalharga;
			$bayar = $header->bayar;


			if ($pilihhutang == 'yes') {

				$totalpembayaran = $totalpembayaran + $hutang;
				$sisa = ($totalpembayaran - $bayar);
			} else {
				$totalpembayaran = $totalpembayaran;
				$sisa = $header->sisa;
			}

			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;



			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(100, 210));
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(6, 8, ' UD.BRILIAN', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(70, 4, '  Jl. Marga Bhakti Rt.03/01', 0, 0, 'L');
			$pdf->Cell(28, 4, $id, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(6, 4, '  Kel.Kertamaya, Kec.Bogor Selatan', 0, 0, 'L');
			$pdf->Cell(92, 4, 'Tanggal : ' . $header->date, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(6, 4, '  Kota Bogor, 16138', 0, 0, 'L');
			$pdf->Cell(92, 4, 'Kepada, Bpk/Ibu : ' . $pelanggan->namapelanggan, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');

			$pdf->Ln();
			$pdf->Cell(6, 4, '  Menjual Macam-Macam Kayu', 0, 0, 'L');
			$pdf->Cell(92, 4, $pelanggan->alamatpelanggan, 0, 0, 'R');
			$pdf->Cell(2, 4, '', 0, 0, 'C');
			$pdf->Ln();
			$pdf->Cell(7, 4, '  (Mahoni, Bayur, Akor, Salam, Mindi DLL)', 0, 0, 'L');
			$pdf->Ln();
			$pdf->Cell(7, 4, '  Telp. 089637410775, 081213570707', 0, 0, 'L');
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 7);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(24, 4, 'Ukran Kayu', 1, '0', 'C', true);
			$pdf->Cell(10, 4, 'Pcs', 1, 0, 'C', true);
			$pdf->Cell(20, 4, 'M3', 1, 0, 'C', true);
			$pdf->Cell(26, 4, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(20, 4, 'Keterangan', 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(8, 4, 'T', 1, 0, 'C', true);
			$pdf->Cell(8, 4, 'L', 1, 0, 'C', true);
			$pdf->Cell(8, 4, 'P', 1, 0, 'C', true);
			$pdf->Cell(76, 4, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->SetFont('Arial', '', 8);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);

			foreach ($detail_header as $tp) {
				$totalqty = $totalqty + $tp->qty;
				$totalm3 = $totalm3 + $tp->m3;
				$totalharga = $totalharga + $tp->totalharga;
				$pdf->Cell(8, 5, $tp->t, 1, 0, 'C', true);
				$pdf->Cell(8, 5, $tp->l, 1, 0, 'C', true);
				$pdf->Cell(8, 5, $tp->p, 1, 0, 'C', true);
				$pdf->Cell(10, 5, $tp->qty, 1, 0, 'C', true);
				$pdf->Cell(20, 5, $tp->m3, 1, 0, 'C', true);
				$pdf->Cell(26, 5, number_format($tp->totalharga), 1, 0, 'C', true);
				$pdf->Cell(20, 5, $tp->ket, 1, 0, 'C', true);
				$pdf->Ln();
			}
			$pdf->Cell(24, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(20, 5, $totalm3, 1, 0, 'C', true);
			$pdf->Cell(26, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(20, 5, '', 1, 0, 'C', true);
			$pdf->Ln();


			if ($pilihhutang == 'yes') {
				$pdf->Cell(54, 5, 'Hutang ', 1, 0, 'R', true);
				$pdf->Cell(26, 5, number_format($hutang), 1, 0, 'C', true);
				$pdf->Cell(20, 5, number_format($hargasetelahhutang), 1, 0, 'C', true);
				$pdf->Ln();
			}
			if (!empty($diskon)) {
				$pdf->Cell(54, 5, 'Diskon ', 1, 0, 'R', true);
				$pdf->Cell(26, 5, number_format($diskon), 1, 0, 'C', true);
				$pdf->Cell(20, 5, number_format($hargasetelahdiskon), 1, 0, 'C', true);
				$pdf->Ln();
			}


			$pdf->Cell(80, 5, 'Total Pembayaran ', 1, 0, 'R', true);
			$pdf->Cell(20, 5, number_format($totalpembayaran), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(80, 5, 'Bayar ', 1, 0, 'R', true);
			$pdf->Cell(20, 5, number_format($bayar), 1, 0, 'C', true);
			$pdf->Ln();
			$pdf->Cell(80, 5, 'Sisa ', 1, 0, 'R', true);
			$pdf->Cell(20, 5, number_format($sisa), 1, 0, 'C', true);

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}
}
