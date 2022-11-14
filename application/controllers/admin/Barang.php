<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('form_validation');
		$this->load->library('datatables');
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
	}




	function cekLevel()
	{

		if ($this->session->userdata('level') == 'admin') {

			return true;
		} else {
			$this->load->view('admin/error_verifikasi');
		}
	}

	function stokBarang()
	{

		//cek apakah ada stock opname dibulan berjalan
		//jika ada perhitungan di mulai tgl stock opname

		$kode = "STOCKOPNAME".date('Ym');
		$cek = $this->db->where('idheader',$kode)->get('header')->row();
		if(!empty($cek)){
			
			$dateMulai = $cek->date;

		}else{
			
			$dateMulai = date('Y-m-').'01';	
		}
		$date = date('Y-m'); //data bulan berjalan
		$ambildata = $this->db->group_by('idbarang')->order_by('idbarang', 'asc')->get('detail_header')->result();
		$arr = array();
		foreach ($ambildata as $t) {

			$pecah = explode('|', $this->stokmasuk($t->idbarang, $date,$dateMulai));
			$qty_masuk = $pecah[0];
			$totalharga = $pecah[1];
			$qtysisa = $qty_masuk - $this->stokkeluar($t->idbarang, $date, $dateMulai);
			$hargasatuan = !empty($qty_masuk) ? $totalharga / $qty_masuk : 0;
			$totalhargasisa = $qtysisa * $hargasatuan;

			$arr[] = array(
				'idbarang' => $t->idbarang,
				't' =>  $t->t,
				'l' =>  $t->l,
				'p' =>  $t->p,
				'qty' =>  $qtysisa,
				'harga' => $hargasatuan,
				'total' => $totalhargasisa,
			);
		}

		$data['data'] = $arr;
		$this->load->view('admin/barang/stokBarang', $data);
	}
	function stokmasuk($idbarang, $date,$dateMulai)
	{

		$qty = $this->db->select('SUM(detail_header.qty) as qty_masuk, SUM(detail_header.totalharga) as totalharga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status !=', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', $date)->get()->row();
		return (!empty($qty->qty_masuk) ? $qty->qty_masuk : 0) . "|" . (!empty($qty->totalharga) ? $qty->totalharga : 0);
	}
	function stokkeluar($idbarang, $date,$dateMulai)
	{

		$qty = $this->db->select('SUM(detail_header.qty) as qty_keluar')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('header.date >=',$dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', $date)->get()->row();
		return (!empty($qty->qty_keluar) ? $qty->qty_keluar : 0);
	}
	function getIdBarang()
	{   //fungsi autocomplete pelanggan 

		$cari = $this->input->get('term', true);
		$auto = $this->db->select('*')->from('detail_header')->where('idbarang', $cari)->group_by('idbarang')->limit(10)->get()->result();



		if (isset($cari)) {
			if (count($auto) == 0) {
				$arr_result[] = array(
					'idbarang'			=> '',
				);
			} else if (count($auto) > 0) {
				foreach ($auto as $row) {

					$arr_result[] = array(
						'idbarang'			=> $row->idbarang,
						't'			=> $row->t,
						'l'			=> $row->l,
						'p'			=> $row->p,

					);
				}
			}
			echo json_encode($arr_result);
		}
	}
	function sinkronStok()
	{
		if ($this->cekLevel()) {
			$data['data'] = $this->db->group_by('idheader')->order_by('idsinkron', 'desc')->get('sinkronstok')->result();
			$this->load->view('admin/barang/sinkronStok', $data);
		}
	}
	function prosesSinkron()
	{
		$idheader = $this->input->get('id', true);

		if (!empty($idheader)) {
			
			$dateNow = date('Y-m-d');
			
			//cek apakah ada stock opname dibulan berjalan
			//jika ada perhitungan di mulai tgl stock opname

			$kode = "STOCKOPNAME".date('Ym', strtotime('-1 month', strtotime($dateNow)));;
			$cek = $this->db->where('idheader',$kode)->get('header')->row();
			if(!empty($cek)){
				
				$dateMulai = $cek->date;

			}else{
				
				$dateMulai = date('Y-m', strtotime('-1 month', strtotime($dateNow)));
				$dateMulai = $dateMulai."-01";
			
			}

			$date = date('Y-m', strtotime('-1 month', strtotime($dateNow))); //ambil bulan kemarin
			$ambildata = $this->db->group_by('idbarang')->get('detail_header')->result();
			$arrHeader = array();
			$arrDetail = array();
			$totalhargastok = 0;
			$totalm3 = 0;
			$totalqty = 0;
			$idheader = 'Sk' . date('Ym');
			//insert sinkron sebagi catatan
			$mulaiSinkron = array(
				'idheader' => $idheader,
				'tanggal' => date('Y-m-d'),
				'timeawal' => date('H:i:s'),
			);

			$this->db->insert('sinkronstok', $mulaiSinkron); //insert sinkron

			foreach ($ambildata as $t) {

				$pecah = explode('|', $this->stokmasuk($t->idbarang, $date,$dateMulai));
				$qty_masuk = $pecah[0];
				$totalharga = $pecah[1];
				$qty_keluar = $this->stokkeluar($t->idbarang, $date,$dateMulai);

				$qtysisa = ($qty_masuk - $qty_keluar);
				$m3 = ($t->t * $t->l * $t->p * $qtysisa) / 1000000;
				$hargasatuan = !empty($qty_masuk) ? round($totalharga / $qty_masuk, 2) : 0;


				$arrDetail[] = array(
					'idheader' => $idheader,
					'date' => date('Y-m-d'),
					'idbarang' => $t->idbarang,
					't' =>  $t->t,
					'l' =>  $t->l,
					'p' =>  $t->p,
					'qty' =>  $qtysisa,
					'm3' => $m3,
					'hargasatuan' => $hargasatuan,
					'totalharga' => ($qtysisa * $hargasatuan),
				);

				$totalqty += ($qty_masuk - $qty_keluar);
				$totalm3 += $m3;
				$totalhargastok += ($qtysisa *  $hargasatuan);
			}


			if (!$this->db->insert_batch('detail_header', $arrDetail)) {

				$this->hapusDbHeader($idheader);
				$this->hapusDbDetail($idheader);

				$updateSinkron = array('status' => 'gagal');
				$where = array('idheader' => $idheader);
				$this->updateDbSinkron($updateSinkron, $where);
				echo json_encode(array('status' => false, 'ket' => 'Proses Sinkron Gagal!!!, Lakukan Dengan Cara Manual!!!'));
				die();
			}


			$dataHeader = array(
				'idheader' => $idheader,
				'date' => date('Y-m-d'),
				'status' => 'awl',
				'totalharga' => $totalhargastok,

			);

			if (!$this->db->insert('header', $dataHeader)) {

				$this->hapusDbHeader($idheader);
				$this->hapusDbDetail($idheader);


				$updateSinkron = array('status' => 'gagal');
				$where = array('idheader' => $idheader);
				$this->updateDbSinkron($updateSinkron, $where);
				echo json_encode(array('status' => false, 'ket' => 'Proses Sinkron Gagal!!!, Lakukan Dengan Cara Manual!!!'));
				die();
			};

			$akhirSinkron = array(
				'timeakhir' => date('H:i:s'),
				'totalbarang' => $totalqty,
				'totalharga' => $totalhargastok,
				'm3' => $totalm3,
				'status' => 'verifikasi',
			);

			$where = array('idheader' => $idheader);
			$this->updateDbSinkron($akhirSinkron, $where);
			echo json_encode(array('status' => true, 'ket' => 'Berhasil!!!'));
		} else {

			redirect(base_url('admin/Barang/sinkronStok'));
		}
	}
	function verifikasiSinkron()
	{

		$idheader = $this->input->get('id', true);
		$date_get =  $this->input->get('date', true);

		if (!empty($idheader)) {

			$dateNow = $date_get;
			
			//cek apakah ada stock opname dibulan berjalan
			//jika ada perhitungan di mulai tgl stock opname

			$kode = "STOCKOPNAME".date('Ym', strtotime('-1 month', strtotime($dateNow)));;
			$cek = $this->db->where('idheader',$kode)->get('header')->row();
			if(!empty($cek)){
				
				$dateMulai = $cek->date;

			}else{
				
				$dateMulai = date('Y-m', strtotime('-1 month', strtotime($dateNow)));
				$dateMulai = $dateMulai."-01";
			
			}

			$date = date('Y-m', strtotime('-1 month', strtotime($dateNow))); //ambil bulan kemarin
			
			$dateLike = date('Y-m', strtotime($date_get));
			$ambildata = $this->db->group_by('idbarang')->get('detail_header')->result();

			foreach ($ambildata as $t) {

				$pecah = explode('|', $this->stokmasuk($t->idbarang, $date,$dateMulai));
				$qty_masuk = (int)$pecah[0];
				$qty_keluar = $this->stokkeluar($t->idbarang, $date,$dateMulai);

				$qtySisa = ($qty_masuk - $qty_keluar); //total sisa qty bulan lalu

				$ambilQty = $this->db->where('idheader', $idheader)->where('idbarang', $t->idbarang)->like('date', $dateLike)->get('detail_header')->row();
				$qtyBaru = $ambilQty->qty;

				//cek apakah data sblmya sma dengan dtang sinkorn dibuat
				if ($qtySisa != $qtyBaru) {
					//jika qtySisa dengan qtyBaru, tidak sama maka sinkron gagal;
					$this->hapusDbHeader($idheader);
					$this->hapusDbDetail($idheader);

					$updateSinkron = array('status' => 'gagal');
					$where = array('idheader' => $idheader);
					$this->updateDbSinkron($updateSinkron, $where);
					echo json_encode(array('status' => false, 'ket' => 'Verifikasi Gagal Dikarnakan Data Sinkron Tidak Sesuai!!!'));
					die();
				}
			}

			$updateSinkron = array('status' => 'berhasil');
			$where = array('idheader' => $idheader);
			$this->updateDbSinkron($updateSinkron, $where);
			echo json_encode(array('status' => true, 'ket' => 'Verifikasi Berhasil!!!'));
		} else {

			redirect(base_url('admin/Barang/sinkronStok'));
		}
	}
	function prosesSinkronUlang()
	{

		$idheader = $this->input->get('id', true);
		$date_get = $this->input->get('date', true);

		if (!empty($idheader)) {
			//hapus data yg lama	
			$this->hapusDbHeader($idheader);
			$this->hapusDbDetail($idheader);
			//

			$dateNow = $date_get;
			//cek apakah ada stock opname dibulan kemarin
			//jika ada perhitungan di mulai tgl stock opname

			$kode = "STOCKOPNAME".date('Ym', strtotime('-1 month', strtotime($dateNow)));;
			$cek = $this->db->where('idheader',$kode)->get('header')->row();
			if(!empty($cek)){
				
				$dateMulai = $cek->date;

			}else{
				
				$dateMulai = date('Y-m', strtotime('-1 month', strtotime($dateNow)));
				$dateMulai = $dateMulai."-01";
			
			}

			$date = date('Y-m', strtotime('-1 month', strtotime($dateNow))); //ambil bulan kemarin
			$ambildata = $this->db->group_by('idbarang')->get('detail_header')->result();
			$arrHeader = array();
			$arrDetail = array();
			$totalhargastok = 0;
			$totalm3 = 0;
			$totalqty = 0;
			$idheader = 'Sk' . date('Ym', strtotime($dateNow));
			//insert sinkron sebagi catatan
			$mulaiSinkron = array(
				'idheader' => $idheader,
				'tanggal' => $dateNow,
				'timeawal' => date('H:i:s'),
			);

			$this->db->insert('sinkronstok', $mulaiSinkron); //insert sinkron

			foreach ($ambildata as $t) {

				$pecah = explode('|', $this->stokmasuk($t->idbarang, $date,$dateMulai));
				$qty_masuk = $pecah[0];
				$totalharga = $pecah[1];
				$qty_keluar = $this->stokkeluar($t->idbarang, $date,$dateMulai);

				$qtysisa = ($qty_masuk - $qty_keluar);
				$m3 = ($t->t * $t->l * $t->p * $qtysisa) / 1000000;
				$hargasatuan = !empty($qty_masuk) ? round($totalharga / $qty_masuk, 2) : 0;


				$arrDetail[] = array(
					'idheader' => $idheader,
					'date' => $dateNow,
					'idbarang' => $t->idbarang,
					't' =>  $t->t,
					'l' =>  $t->l,
					'p' =>  $t->p,
					'qty' =>  $qtysisa,
					'm3' => $m3,
					'hargasatuan' => $hargasatuan,
					'totalharga' => ($qtysisa * $hargasatuan),
				);

				$totalqty += ($qty_masuk - $qty_keluar);
				$totalm3 += $m3;
				$totalhargastok += ($qtysisa *  $hargasatuan);
			}


			if (!$this->db->insert_batch('detail_header', $arrDetail)) {

				$this->hapusDbHeader($idheader);
				$this->hapusDbDetail($idheader);

				$updateSinkron = array('status' => 'gagal');
				$where = array('idheader' => $idheader);
				$this->updateDbSinkron($updateSinkron, $where);
				echo json_encode(array('status' => false, 'ket' => 'Proses Sinkron Gagal!!!, Lakukan Dengan Cara Manual!!!'));
				die();
			}


			$dataHeader = array(
				'idheader' => $idheader,
				'date' => $dateNow,
				'status' => 'awl',
				'totalharga' => $totalhargastok,

			);

			if (!$this->db->insert('header', $dataHeader)) {

				$this->hapusDbHeader($idheader);
				$this->hapusDbDetail($idheader);


				$updateSinkron = array('status' => 'gagal');
				$where = array('idheader' => $idheader);
				$this->updateDbSinkron($updateSinkron, $where);
				echo json_encode(array('status' => false, 'ket' => 'Proses Sinkron Gagal!!!, Lakukan Dengan Cara Manual!!!'));
				die();
			};

			$akhirSinkron = array(
				'timeakhir' => date('H:i:s'),
				'totalbarang' => $totalqty,
				'totalharga' => $totalhargastok,
				'm3' => $totalm3,
				'status' => 'verifikasi',
			);

			$where = array('idheader' => $idheader);
			$this->updateDbSinkron($akhirSinkron, $where);
			echo json_encode(array('status' => true, 'ket' => 'Berhasil!!!'));
		} else {

			redirect(base_url('admin/Barang/sinkronStok'));
		}
	}
	function hapusDbHeader($var)
	{

		return $this->db->delete('header', array('idheader' => $var));
	}
	function hapusDbDetail($var)
	{

		return	$this->db->delete('detail_header', array('idheader' => $var));
	}
	function hapusDbSinkron($var)
	{

		return	$this->db->delete('sinkronstok', array('idheader' => $var));
	}
	function updateDbSinkron($data, $where)
	{

		return	$this->db->update('sinkronstok', $data, $where);
	}
	function pergerakanStok()
	{

		$tglP = empty($this->input->post('tglP', true)) ? date('Y-m-') . '01' : $this->input->post('tglP', true);
		$tglK = empty($this->input->post('tglK', true)) ? date('Y-m-d') : $this->input->post('tglK', true);

		$blnP = substr($tglP, 5, 2);
		$blnK = substr($tglK, 5, 2);

		if ($blnP != $blnK) { //jika bulannya berbeda maka akan di set sesuai tanggal di bulan berjalan
			$tglP = date('Y-m-') . '01';
			$tglK = date('Y-m-d');
		}

		$data['tglP'] = $tglP;
		$data['tglK'] = $tglK;
		$date = empty($tglP) ? date('Y-m') : date('Y-m', strtotime($tglP));
		$kodeIdHeder = date('Ym', strtotime($tglP));

		//cek apakah ada stock opname dibulan berjalan
		//jika ada perhitungan di mulai tgl stock opname

		$dateNow = $date."-01";
		$kode = "STOCKOPNAME".date('Ym',strtotime($dateNow));;
		$cek = $this->db->where('idheader',$kode)->get('header')->row();
		if(!empty($cek)){
			
			$tglStockOpname= $cek->date;
			if($tglP >= $tglStockOpname){
				
				$tglP = $tglP;
				
			}else{

				$tglP = $tglStockOpname;
			}

			$tglK = $tglK;
			$idheader = $kode;  //kode awal
		

		}else{
			
			$tglP = $tglP;
			$tglK = $tglK;
			$idheader = empty($tglP) ? 'Sk' . date('Ym') : 'Sk' . $kodeIdHeder;  //kode awal
		
		
		}


		$ambildata = $this->db->group_by('idbarang')->order_by('idbarang', 'asc')->get('detail_header')->result();
		$arr = array();
		foreach ($ambildata as $t) {

			//total stok terakhir bulan sblmnya
			$stokMasukAwal = $this->db->select("SUM(qty) as qty, SUM(m3) as m3, SUM(hargasatuan) as hargasatuan, SUM(totalharga) as totalharga")->where('idheader', $idheader)->where('idbarang', $t->idbarang)->like('date', $date)->get('detail_header')->row();
			$qtyAwal = empty($stokMasukAwal->qty) ? 0 : $stokMasukAwal->qty;
			$m3Awal = empty($stokMasukAwal->m3) ? 0 : $stokMasukAwal->m3;
			//$hargaSatuanAwal = empty($stokMasukAwal->hargasatuan) ? 0 : $stokMasukAwal->hargasatuan;
			$totalHargaAwal = empty($stokMasukAwal->totalharga) ? 0 : $stokMasukAwal->totalharga;

			//barang masuk
			$qtyMasukBerjalan = $this->db->select('SUM(detail_header.qty) as qty, SUM(detail_header.m3) as m3, SUM(detail_header.hargasatuan) as hargasatuan, SUM(detail_header.totalharga) as totalharga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status','pmb')->where('detail_header.idbarang', $t->idbarang)->where('detail_header.date >=', $tglP)->where('detail_header.date <=', $tglK)->get()->row();
			$qtyMasuk = empty($qtyMasukBerjalan->qty) ? 0 : $qtyMasukBerjalan->qty;
			$m3Masuk =  empty($qtyMasukBerjalan->m3) ? 0 : $qtyMasukBerjalan->m3;
			$totalHargaMasuk = empty($qtyMasukBerjalan->totalharga) ? 0 : $qtyMasukBerjalan->totalharga;
			//$hargaSatuanMasuk = empty($totalHargaMasuk / $qtyMasuk) ? 0 : $totalHargaMasuk / $qtyMasuk;

			//barang keluar
			$qtyKeluarBerjalan = $this->db->select('SUM(detail_header.qty) as qty, SUM(detail_header.m3) as m3, SUM(detail_header.hargasatuan) as hargasatuan, SUM(detail_header.totalharga) as totalharga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('detail_header.idbarang', $t->idbarang)->where('detail_header.date >=', $tglP)->where('detail_header.date <=', $tglK)->get()->row();
			$qtyKeluar = empty($qtyKeluarBerjalan->qty) ? 0 : $qtyKeluarBerjalan->qty;
			$m3Keluar = empty($qtyKeluarBerjalan->m3) ? 0 : $qtyKeluarBerjalan->m3;
			$totalHargaKeluar = empty($qtyKeluarBerjalan->totalharga) ? 0 : $qtyKeluarBerjalan->totalharga;
			//$hargaSatuanKeluar = empty($totalHargaKeluar / $qtyKeluar) ? 0 : $totalHargaKeluar / $qtyKeluar;


			$hargatotalsisa = $totalHargaAwal + $totalHargaMasuk;

			$qtytotalsisa = $qtyAwal + $qtyMasuk;

			if (empty($hargatotalsisa) && empty($qtytotalsisa)) {

				$hargasisa = 0;
			} else {

				$hargasisa = (($totalHargaAwal + $totalHargaMasuk) / ($qtyAwal + $qtyMasuk));
			}

			$totalsisa = $totalHargaAwal + $totalHargaMasuk;

			if (empty($totalsisa) && empty($qtytotalsisa)) {

				$totalsisa = 0 * (($qtyAwal + $qtyMasuk) - $qtyKeluar);
			} else {

				$totalsisa = (($totalHargaAwal + $totalHargaMasuk) / ($qtyAwal + $qtyMasuk)) * (($qtyAwal + $qtyMasuk) - $qtyKeluar);
			}



			$arr[] = array(
				'idbarang' => $t->idbarang,
				'qtyawal' =>  $qtyAwal,
				'm3awal' =>  round($m3Awal, 5),
				'totalawal' => $totalHargaAwal,
				'qtymasuk' => $qtyMasuk,
				'm3masuk' => round($m3Masuk, 5),
				'totalmasuk' => $totalHargaMasuk,
				'qtykeluar' => $qtyKeluar,
				'm3keluar' => round($m3Keluar, 5),
				'totalkeluar' => $totalHargaKeluar,
				'qtysisa' => (($qtyAwal + $qtyMasuk) - $qtyKeluar),
				'm3sisa' => round(($m3Awal + $m3Masuk) - $m3Keluar, 5),
				'hargasisa' => $hargasisa,
				'totalsisa' =>  $totalsisa,
			);
		}

		$data['data'] = $arr;
		$this->load->view('admin/barang/pergerakanStok', $data);
	}


	public function stockOpname()
	{
		$data['data'] = $this->db->select("header.date,user.username,header.idheader,SUM(detail_header.qty) AS qty, SUM(detail_header.m3) AS m3, header.totalharga, header.keterangan")->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->join('user', 'user.iduser=header.iduser')->where('header.status', 'sto')->order_by('header.date', 'DESC')->get()->result();
		$this->load->view('admin/barang/stockOpname', $data);
		
	}


	public function formStockOpname()
	{

		$data['user'] = $this->session->userdata('iduser');
		$data['po'] = "STOCKOPNAME" . date('Ym');
		$this->load->view('admin/barang/formStockOpname', $data);
	}

	public function simpanStockOpname()
	{

		$po = $this->input->post('po', true);

		$iduser = $this->input->post('user', true);
		$date = $this->input->post('date', true);
		$keterangan = $this->input->post('namaketerangan', true);
		$totalpcs = $this->input->post('totalpcs', true);
		$totalm3 = $this->input->post('totalm3', true);
		$totalsubtotal = str_replace(',', '', $this->input->post('totalsubtotal', true));

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
			} else if ($t > '0' && $l > '0' && $p > '0' && $pcs > 0 && $hargam3 <= 0) {
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




		$dataHeader = array(
			'idheader' => $po,
			'iduser' => $iduser,
			'date' => $date,
			'status' => 'sto', //sto artinya stock opname
			'totalharga' => $totalsubtotal,
			'keterangan' => $keterangan,
		);

		$dataSinkron = array(
			'idheader' => $po,
			'tanggal' => $date,
			'totalbarang' => $totalpcs,
			'm3' => $totalm3,
			'totalharga' => $totalsubtotal,
			'timeawal' =>  date('H:i:s'),
			'timeakhir' =>  date('H:i:s'),
			'status'	=> 'Stock Opname',
		);

		if (!$this->db->insert('header', $dataHeader)) {

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbSinkron($po);
			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}


		//insert detail

		if (!$this->db->insert_batch('detail_header', $dataDetail)) {  //insert multie detail

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbSinkron($po);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}


		$kode = 'Sk'.date('Ym');
		$this->db->delete('sinkronstok',array('idheader' => $kode)); //hapus data sinkron karena akan di gantikan dengan stock opname
		if (!$this->db->insert('sinkronstok', $dataSinkron)) {  //insert jejak sinkron

			//jika error maka akan menghapus inputan yg lain
			$this->hapusDbHeader($po);
			$this->hapusDbDetail($po);
			$this->hapusDbSinkron($po);

			echo json_encode(array('status' => false, 'ket' => 'Gagal Menyimpan Harap ulangi dan Muat Ulang Browser!'));
			die();
		}



		echo json_encode(array('status' => true, 'ket' => 'Berhasil Di Simpan!'));
		die();
	}

	public function detailStockOpname($idheader)
	{

		$data['header'] = $this->db->where('idheader', $idheader)->get('header')->row();
		$data['detail_header'] = $this->db->where('idheader', $idheader)->order_by('iddetail', 'ASC')->get('detail_header')->result();
		$this->load->view('admin/barang/ajax_detailStockOpname', $data);
	}


	public function editStockOpname()
	{

		$idheader = $this->input->post('idheader', true);
		$data['header'] = $this->db->where('idheader', $idheader)->get('header')->row();
		$data['detail_header'] = $this->db->where('idheader', $idheader)->order_by('iddetail', 'ASC')->get('detail_header')->result();
		$this->load->view('admin/barang/editFormStockOpname', $data);
	}


	public function hapusStockOpname()
	{


		if ($this->session->userdata('level') == 'admin') {
			$idheader = $this->input->post('id', true);
			if (!$this->hapusDbHeader($idheader)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbDetail($idheader)) {

				echo json_encode(array('status' => false, 'ket' => 'Gagal Melakukan Proses Hapus!!!'));
				die();
			}

			if (!$this->hapusDbSinkron($idheader)) {

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


	public function print1($id)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {

			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();
			//$ambilpiutang = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer',$header->idsuplayer)->where('idheader !=',$id)->get()->row();

			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;

			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(210, 297));
			$pdf->SetMargins(0, 8, 0);
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(210, 5, 'STOCK OPNAME', 1, '0', 'C', true);
			$pdf->Ln();
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
			$pdf->Cell(30, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(30, 5, $totalm3, 1, 0, 'C', true);
			$pdf->Cell(40, 5, '', 1, 0, 'C', true);
			$pdf->Cell(40, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Cell(30, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}
	public function print2($id)
	{

		$header = $this->db->where('idheader', $id)->get('header')->row();
		if (!empty($header)) {

			$detail_header = $this->db->where('idheader', $id)->order_by('iddetail', 'asc')->get('detail_header')->result();
			//$ambilpiutang = $this->db->select('(SUM(totalhutang) - SUM(bayarhutang)) as sisahutang')->from('hutang')->where('idsuplayer',$header->idsuplayer)->where('idheader !=',$id)->get()->row();


			$totalharga = 0; //detail
			$totalqty = 0;
			$totalm3 = 0;


			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', array(210, 297));
			$pdf->SetMargins(0, 8, 0);
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetFillColor(0, 255, 0);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->Cell(210, 5, 'STOCK OPNAME', 1, '0', 'C', true);
			$pdf->Ln();
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
			$pdf->Cell(30, 5, 'Jumlah', 1, 0, 'C', true);
			$pdf->Cell(10, 5, $totalqty, 1, 0, 'C', true);
			$pdf->Cell(30, 5, number_format($totalm3, 3), 1, 0, 'C', true);
			$pdf->Cell(50, 5, '', 1, 0, 'C', true);
			$pdf->Cell(50, 5, number_format($totalharga), 1, 0, 'C', true);
			$pdf->Cell(40, 5, '', 1, 0, 'C', true);
			$pdf->Ln();

			$pdf->Output();
		} else {

			redirect(base_url());
		}
	}


	function tes()
	{

		$dateNow = date('Y-m-d');
		$blnP = substr($dateNow, 5, 2);
		echo $blnP;
	}
}
