<?php

class Dashboard extends CI_Controller
{

	function __construct()
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
		if ($this->cekLevel()) {

			$data['priode'] = date("Y-m-d");
			$tunai = $this->db->select('(SUM(totalharga-sisa)) as tunai')->from('header')->where('status', 'pnj')->where('date', date('Y-m-d'))->group_by('status')->get()->row();
			$data['tunai'] = (!empty($tunai->tunai) ? $tunai->tunai : 0);

			$hutang = $this->db->select('SUM(totalhutang) as hutang')->from('hutang')->where('idpelanggan !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['hutang'] = $hutang->hutang;

			//pelanggan bayar hutang
			$pelunasan = $this->db->select('SUM(bayarhutang) as pelunasan')->from('hutang')->where('idpelanggan !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['pelunasan'] = $pelunasan->pelunasan;


			//rinci piutang pelanggan
			$rincipiutang = $this->db->query("SELECT (SELECT namapelanggan From pelanggan WHERE idpelanggan=a.idpelanggan) AS namapelanggan, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idpelanggan = a.idpelanggan GROUP BY idpelanggan) AS sisahutang  FROM hutang AS a WHERE a.date ='" . date('Y-m-d') . "' AND a.idpelanggan !='' AND a.bayarhutang > 0 GROUP BY a.idpelanggan")->result();
			$data['rincibayarpiutang'] = $rincipiutang;



			//bayar hutang ke suplayer
			$bayarhutang = $this->db->select('SUM(bayarhutang) as bayarhutang')->from('hutang')->where('idsuplayer !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['bayarhutang'] = $bayarhutang->bayarhutang;


			//sisa hutang ke suplayer
			$sisahutang = $this->db->query("SELECT SUM(sisa) AS sisa FROM (SELECT (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) AS sisa FROM `hutang` JOIN suplayer on hutang.idsuplayer=suplayer.idsuplayer WHERE suplayer.idsuplayer !='' GROUP BY suplayer.idsuplayer) AS hutang")->row();
			$data['sisahutang'] = $sisahutang->sisa;

			// rinci hutang ke suplayer
			$rincihutang = $this->db->query("SELECT (SELECT namasuplayer From suplayer WHERE idsuplayer=a.idsuplayer) AS namasuplayer, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idsuplayer = a.idsuplayer GROUP BY idsuplayer) AS sisahutang  FROM hutang AS a WHERE a.date ='" . date('Y-m-d') . "' AND a.idsuplayer !='' AND a.bayarhutang > 0  GROUP BY a.idsuplayer")->result();
			$data['rincibayarhutang'] = $rincihutang;




			$laba = $this->db->select('SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty) as laba')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pnj')
				->where('header.date', date('Y-m-d'))
				->get()->row();
			$diskon = $this->db->select('SUM(diskon) as diskon')->from('header')->where('status', 'pnj')->where('date', date('Y-m-d'))->get()->row();
			$data['laba'] = $laba->laba - $diskon->diskon;  //mencari laba bersih

			$pembelian = $this->db->select('SUM(totalharga) as totalpembelian')->from('header')->where('status', 'pmb')->where('date', date('Y-m-d'))->get()->row();
			$data['pembelian'] = $pembelian->totalpembelian;

			$pengeluaran = $this->db->select('SUM(nominal)as totalpengeluaran')->from('pengeluaran')->where('date', date('Y-m-d'))->get()->row();
			$data['pengeluaran'] = $pengeluaran->totalpengeluaran;



			$data['jlmPembelian'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, suplayer.namasuplayer')->from('header')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pmb')
				->group_by('header.idsuplayer')
				->order_by('header.totalharga', 'desc')
				->get()->result();




			$data['jlmPenjualan'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, namapelanggan,  (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('header.idpelanggan')
				->order_by('header.totalharga', 'desc')
				->get()->result();







			$data['pembelianBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pmb')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$data['penjualanBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga, (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();




			$data['banyakBarang'] = $this->db->select('detail_header.idbarang, SUM(detail_header.qty) as totalpcs, detail_header.t, detail_header.l, detail_header.p')->from('detail_header')
				->join('header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$this->template->displayFullAdmin('admin/dashboard/index', $data);
		}
	}

	public function index_ajax()
	{
		if ($this->cekLevel()) {

			$data['priode'] = date("Y-m-d");
			$tunai = $this->db->select('(SUM(totalharga-sisa)) as tunai')->from('header')->where('status', 'pnj')->where('date', date('Y-m-d'))->group_by('status')->get()->row();
			$data['tunai'] = (!empty($tunai->tunai) ? $tunai->tunai : 0);

			$hutang = $this->db->select('SUM(totalhutang) as hutang')->from('hutang')->where('idpelanggan !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['hutang'] = $hutang->hutang;

			//pelanggan bayar hutang
			$pelunasan = $this->db->select('SUM(bayarhutang) as pelunasan')->from('hutang')->where('idpelanggan !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['pelunasan'] = $pelunasan->pelunasan;


			//sisa piutang pelanggan
			$rincipiutang = $this->db->query("SELECT (SELECT namapelanggan From pelanggan WHERE idpelanggan=a.idpelanggan) AS namapelanggan, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idpelanggan = a.idpelanggan GROUP BY idpelanggan) AS sisahutang  FROM hutang AS a WHERE a.date ='" . date('Y-m-d') . "' AND a.idpelanggan !=''AND a.bayarhutang > 0 GROUP BY a.idpelanggan")->result();
			$data['rincibayarpiutang'] = $rincipiutang;



			//bayar hutang ke suplayer
			$bayarhutang = $this->db->select('SUM(bayarhutang) as bayarhutang')->from('hutang')->where('idsuplayer !=', '')->where('date', date('Y-m-d'))->get()->row();
			$data['bayarhutang'] = $bayarhutang->bayarhutang;


			//sisa hutang ke suplayer
			$sisahutang = $this->db->query("SELECT SUM(sisa) AS sisa FROM (SELECT (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) AS sisa FROM `hutang` JOIN suplayer on hutang.idsuplayer=suplayer.idsuplayer WHERE suplayer.idsuplayer !='' GROUP BY suplayer.idsuplayer) AS hutang")->row();
			$data['sisahutang'] = $sisahutang->sisa;

			// rinci hutang ke suplayer
			$rincihutang = $this->db->query("SELECT (SELECT namasuplayer From suplayer WHERE idsuplayer=a.idsuplayer) AS namasuplayer, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idsuplayer = a.idsuplayer GROUP BY idsuplayer) AS sisahutang  FROM hutang AS a WHERE a.date ='" . date('Y-m-d') . "' AND a.idsuplayer !='' AND a.bayarhutang > 0 GROUP BY a.idsuplayer")->result();
			$data['rincibayarhutang'] = $rincihutang;




			$laba = $this->db->select('SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty) as laba')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pnj')
				->where('header.date', date('Y-m-d'))
				->get()->row();
			$diskon = $this->db->select('SUM(diskon) as diskon')->from('header')->where('status', 'pnj')->where('date', date('Y-m-d'))->get()->row();
			$data['laba'] = $laba->laba - $diskon->diskon;  //mencari laba bersih

			$pembelian = $this->db->select('SUM(totalharga) as totalpembelian')->from('header')->where('status', 'pmb')->where('date', date('Y-m-d'))->get()->row();
			$data['pembelian'] = $pembelian->totalpembelian;

			$pengeluaran = $this->db->select('SUM(nominal)as totalpengeluaran')->from('pengeluaran')->where('date', date('Y-m-d'))->get()->row();
			$data['pengeluaran'] = $pengeluaran->totalpengeluaran;



			$data['jlmPembelian'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, suplayer.namasuplayer')->from('header')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pmb')
				->group_by('header.idsuplayer')
				->order_by('header.totalharga', 'desc')
				->get()->result();




			$data['jlmPenjualan'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, namapelanggan,  (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('header.idpelanggan')
				->order_by('header.totalharga', 'desc')
				->get()->result();







			$data['pembelianBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pmb')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$data['penjualanBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga, (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();




			$data['banyakBarang'] = $this->db->select('detail_header.idbarang, SUM(detail_header.qty) as totalpcs, detail_header.t, detail_header.l, detail_header.p')->from('detail_header')
				->join('header', 'header.idheader=detail_header.idheader')
				->where('header.date', date('Y-m-d'))
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$this->load->view('admin/dashboard/index', $data);
		}
	}


	public function laporanPembelianBarang()
	{
		if ($this->cekLevel()) {

			$data['sp'] = $this->db->get('suplayer')->result();
			$data['user'] = $this->db->get('user')->result();
			$this->load->view('admin/dashboard/laporanPembelian', $data);
		}
	}

	public function ajax_laporanPembelian()
	{
		if ($this->cekLevel()) {
			$tglP = trim($this->input->post('tglP', true));
			$tglK = trim($this->input->post('tglK', true));
			$idsuplayer = trim($this->input->post('idsuplayer', true));
			$iduser = trim($this->input->post('iduser', true));
			$jenis = $this->input->post('jenis', true);

			if ($jenis == "rinci") {

				$data['data'] = $this->db->select('header.idheader, SUM(detail_header.qty)as totalqty, SUM((detail_header.t*detail_header.l*detail_header.p*detail_header.qty)/1000000) as totalm3, user.username, header.date, suplayer.namasuplayer, suplayer.alamatsuplayer, header.totalharga, 0 AS jumlah')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->join('user', 'user.iduser=header.iduser')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->where('header.date >=', $tglP)
				->where('header.date <=', $tglK)
				->where('header.status', 'pmb')
				->like('header.iduser', $iduser)
				->like('header.idsuplayer', $idsuplayer)
				->group_by('header.idheader')
				->order_by('detail_header.iddetail', 'desc')
				->get()->result();
				$data['jenis'] = $jenis;
				$data['user'] = $iduser;
				$data['titlel'] = 'Laporan Pembelian';
				$this->load->view('admin/dashboard/ajax_laporanPembelian', $data);
			} else {

				$sql ="
						SELECT COUNT(idheader) AS jumlah, SUM(totalqty) AS totalqty, SUM(totalm3) AS totalm3, username, namasuplayer,alamatsuplayer, SUM(totalharga) AS totalharga 
						FROM (
							SELECT 
								`header`.`idheader`, 
								`header`.`idsuplayer`,
								SUM(detail_header.qty) AS totalqty, 
								SUM((detail_header.t*detail_header.l*detail_header.p*detail_header.qty)/1000000) AS totalm3, 
								`user`.`username`, 
								`header`.`date`, 
								`suplayer`.`namasuplayer`, 
								`suplayer`.`alamatsuplayer`, 
								`header`.`totalharga`, 
								0 AS `jumlah` 
							FROM `header` 
							JOIN `detail_header` ON `detail_header`.`idheader`=`header`.`idheader` 
							JOIN `user` ON `user`.`iduser`=`header`.`iduser` 
							JOIN `suplayer` ON `suplayer`.`idsuplayer`=`header`.`idsuplayer` 
							WHERE 
								`header`.`date` >= '".$tglP."' AND 
								`header`.`date` <= '".$tglK."' AND 
								`header`.`status` = 'pmb' AND 
								`header`.`iduser` LIKE '%".$iduser."%' AND 
								`header`.`idsuplayer` LIKE '%".$idsuplayer."%' 
							GROUP BY `header`.`idheader`
						) AS gabung GROUP BY idsuplayer";


				$data['data'] = $this->db->query($sql)->result();
				
				$data['jenis'] = $jenis;
				$data['user'] = $iduser;
				$data['titlel'] = 'Laporan Rekap Pembelian';
				$this->load->view('admin/dashboard/ajax_laporanPembelian', $data);
			}
		}
	}


	public function laporanDetailPembelian($notaPembelian = null)
	{
		if ($this->cekLevel()) {
			if (!empty($notaPembelian)) {
				$data['row'] = $this->db->select('*')->from('header')
					->join('user', 'user.iduser=header.iduser')
					->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
					->where('header.idheader', $notaPembelian)
					->get()->row();

				$data['data'] = $this->db->where('idheader', $notaPembelian)->order_by('iddetail', 'asc')->get('detail_header')->result();

				$this->load->view('admin/dashboard/laporanDetailPembelian', $data);
			}
		}
	}



	public function laporanPenjualanBarang()
	{
		if ($this->cekLevel()) {

			$data['user'] = $this->db->get('user')->result();
			$data['pelanggan'] = $this->db->get('pelanggan')->result();
			$this->load->view('admin/dashboard/laporanPenjualan', $data);
		}
	}


	public function ajax_laporanPenjualan()
	{
		if ($this->cekLevel()) {
			$tglP = trim($this->input->post('tglP', true));
			$tglK = trim($this->input->post('tglK', true));
			$idpelanggan = trim($this->input->post('idpelanggan', true));
			$iduser = trim($this->input->post('iduser', true));
			$jenis = $this->input->post('jenis', true);

			if ($jenis == "rinci") {

				
				$data['data'] = $this->db->select('header.idheader, SUM(detail_header.qty)as totalqty, SUM((detail_header.t*detail_header.l*detail_header.p*detail_header.qty)/1000000) as totalm3, ((SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) - header.diskon) as laba, user.username, header.date, pelanggan.namapelanggan, pelanggan.alamatpelanggan, header.totalharga, 0 AS jumlah')->from('header')
					->join('detail_header', 'detail_header.idheader=header.idheader')
					->join('user', 'user.iduser=header.iduser')
					->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
					->where('header.date >=', $tglP)
					->where('header.date <=', $tglK)
					->where('header.status', 'pnj')
					->like('header.iduser', $iduser)
					->like('header.idpelanggan', $idpelanggan)
					->group_by('header.idheader')
					->order_by('detail_header.iddetail', 'desc')
					->get()->result();

				$data['jenis'] = $jenis;
				$data['user'] = $iduser;
				$data['titlel'] = 'Laporan Penjualan ';

				$this->load->view('admin/dashboard/ajax_laporanPenjualan', $data);

			}else{

				

				$sql ="
						SELECT COUNT(idheader) AS jumlah, SUM(totalqty) AS totalqty, SUM(totalm3) AS totalm3, SUM(laba) AS laba, username, namapelanggan,alamatpelanggan, SUM(totalharga) AS totalharga 
						FROM (
							SELECT 
								`header`.`idheader`, 
								`header`.`idpelanggan`,
								SUM(detail_header.qty) AS totalqty, 
								SUM((detail_header.t*detail_header.l*detail_header.p*detail_header.qty)/1000000) AS totalm3, 
								((SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) - header.diskon) AS laba, 
								`user`.`username`, 
								`header`.`date`, 
								`pelanggan`.`namapelanggan`, 
								`pelanggan`.`alamatpelanggan`, 
								`header`.`totalharga`, 
								0 AS `jumlah` 
							FROM `header` 
							JOIN `detail_header` ON `detail_header`.`idheader`=`header`.`idheader` 
							JOIN `user` ON `user`.`iduser`=`header`.`iduser` 
							JOIN `pelanggan` ON `pelanggan`.`idpelanggan`=`header`.`idpelanggan` 
							WHERE 
								`header`.`date` >= '".$tglP."' AND 
								`header`.`date` <= '".$tglK."' AND 
								`header`.`status` = 'pnj' AND 
								`header`.`iduser` LIKE '%".$iduser."%' AND 
								`header`.`idpelanggan` LIKE '%".$idpelanggan."%' 
							GROUP BY `header`.`idheader`
						) AS gabung GROUP BY idpelanggan";


					$data['data'] = $this->db->query($sql)->result();
				
					$data['jenis'] = $jenis;
					$data['user'] = $iduser;
					$data['titlel'] = 'Laporan Rekap Penjualan ';


					$this->load->view('admin/dashboard/ajax_laporanPenjualan', $data);

			}	
		}
	}




	public function laporanDetailPenjualan($notaPembelian = null)
	{
		if ($this->cekLevel()) {
			if (!empty($notaPembelian)) {
				$data['row'] = $this->db->select('*')->from('header')
					->join('user', 'user.iduser=header.iduser')
					->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
					->where('header.idheader', $notaPembelian)
					->get()->row();

				$data['data'] = $this->db->select('header.date,detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, detail_header.qty, detail_header.m3, detail_header.totalharga as totalharga, detail_header.hargamodal, detail_header.hargasatuan, detail_header.ket')->from('header')
					->join('detail_header', 'header.idheader=detail_header.idheader')
					->where('header.status', 'pnj')
					->where('header.idheader', $notaPembelian)
					->group_by('detail_header.iddetail')
					->order_by('detail_header.iddetail', 'desc')
					->get()->result();



				$this->load->view('admin/dashboard/laporanDetailPenjualan', $data);
			}
		}
	}



	public function laporanPerminggu()
	{
		if ($this->cekLevel()) {
			$hari = date("D");

			switch ($hari) {
				case 'Sun':
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-6 days', strtotime($dateNow)));
					break;

				case 'Mon':
					//$hari_ini = "Senin";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d');
					break;

				case 'Tue':
					//$hari_ini = "Selasa";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-1 days', strtotime($dateNow)));
					break;

				case 'Wed':
					//$hari_ini = "Rabu";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-2 days', strtotime($dateNow)));
					break;

				case 'Thu':
					//$hari_ini = "Kamis";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-3 days', strtotime($dateNow)));
					break;

				case 'Fri':
					//$hari_ini = "Jumat";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-4 days', strtotime($dateNow)));
					break;

				case 'Sat':
					//$hari_ini = "Sabtu";
					$dateNow = date('Y-m-d');
					$dateSebelum = date('Y-m-d', strtotime('-5 days', strtotime($dateNow)));
					break;

				default:
					$hari_ini = "Tidak di ketahui";
					break;
			}



			
			$data['priode'] = $dateSebelum . " s/d " . $dateNow;
			$tunai = $this->db->select('(SUM(totalharga-sisa)) as tunai')->from('header')->where('status', 'pnj')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->group_by('status')->get()->row();
			$data['tunai'] = (!empty($tunai->tunai) ? $tunai->tunai : 0);

			$laba = $this->db->select('SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty) as laba')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pnj')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->get()->row();

			$diskon = $this->db->select('SUM(diskon) as diskon')->from('header')->where('status', 'pnj')->where('header.date >=', $dateSebelum)->where('header.date <= ', $dateNow)->get()->row();
			$data['laba'] = $laba->laba - $diskon->diskon;  //mencari laba bersih

			$hutang = $this->db->select('SUM(totalhutang) as hutang')->from('hutang')->where('idpelanggan !=', '')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['hutang'] = $hutang->hutang;

			$pelunasan = $this->db->select('SUM(bayarhutang) as pelunasan')->from('hutang')->where('idpelanggan !=', '')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pelunasan'] = $pelunasan->pelunasan;


			//rinci piutang pelanggan
			$rincipiutang = $this->db->query("SELECT (SELECT namapelanggan From pelanggan WHERE idpelanggan=a.idpelanggan) AS namapelanggan, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idpelanggan = a.idpelanggan GROUP BY idpelanggan) AS sisahutang  FROM hutang AS a WHERE a.date >='".$dateSebelum."' AND a.date <='" .  $dateNow . "' AND a.idpelanggan !='' AND a.bayarhutang > 0 GROUP BY a.idpelanggan")->result();
			$data['rincibayarpiutang'] = $rincipiutang;



			//bayar hutang ke suplayer
			$bayarhutang = $this->db->select('SUM(bayarhutang) as bayarhutang')->from('hutang')->where('idsuplayer !=', '')->where('date >=', $dateSebelum)->where('date <=',$dateNow)->get()->row();
			$data['bayarhutang'] = $bayarhutang->bayarhutang;


			//sisa hutang ke suplayer
			$sisahutang = $this->db->query("SELECT SUM(sisa) AS sisa FROM (SELECT (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) AS sisa FROM `hutang` JOIN suplayer on hutang.idsuplayer=suplayer.idsuplayer WHERE suplayer.idsuplayer !='' GROUP BY suplayer.idsuplayer) AS hutang")->row();
			$data['sisahutang'] = $sisahutang->sisa;

			// rinci hutang ke suplayer
			$rincihutang = $this->db->query("SELECT (SELECT namasuplayer From suplayer WHERE idsuplayer=a.idsuplayer) AS namasuplayer, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idsuplayer = a.idsuplayer GROUP BY idsuplayer) AS sisahutang  FROM hutang AS a WHERE a.date >='".$dateSebelum."' AND a.date <='" .  $dateNow . "' AND a.idsuplayer !='' AND a.bayarhutang > 0 GROUP BY a.idsuplayer")->result();
			$data['rincibayarhutang'] = $rincihutang;







			$pembelian = $this->db->select('SUM(totalharga) as totalpembelian')->from('header')->where('status', 'pmb')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pembelian'] = $pembelian->totalpembelian;

			$pengeluaran = $this->db->select('SUM(nominal)as totalpengeluaran')->from('pengeluaran')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pengeluaran'] = $pengeluaran->totalpengeluaran;



			$data['jlmPembelian'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, suplayer.namasuplayer')->from('header')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pmb')
				->group_by('header.idsuplayer')
				->order_by('header.totalharga', 'desc')
				->get()->result();




			$data['jlmPenjualan'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, namapelanggan,  (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('header.idpelanggan')
				->order_by('header.totalharga', 'desc')
				->get()->result();






			$data['pembelianBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pmb')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();

			$data['penjualanBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga, (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$data['banyakBarang'] = $this->db->select('detail_header.idbarang, SUM(detail_header.qty) as totalpcs, detail_header.t, detail_header.l, detail_header.p')->from('detail_header')
				->join('header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$this->load->view('admin/dashboard/index', $data);
		}
	}


	public function laporanPerbulan()
	{
		if ($this->cekLevel()) {
			$dateNow = date("Y-m-d");
			$dateSebelum = date("Y-m-") . "01";


			$data['priode'] = $dateSebelum . " s/d " . $dateNow;
			$tunai = $this->db->select('(SUM(totalharga-sisa)) as tunai')->from('header')->where('status', 'pnj')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->group_by('status')->get()->row();
			$data['tunai'] = (!empty($tunai->tunai) ? $tunai->tunai : 0);

			$laba = $this->db->select('SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty) as laba')->from('header')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.status', 'pnj')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->get()->row();

			$diskon = $this->db->select('SUM(diskon) as diskon')->from('header')->where('status', 'pnj')->where('header.date >=', $dateSebelum)->where('header.date <= ', $dateNow)->get()->row();
			$data['laba'] = $laba->laba - $diskon->diskon;  //mencari laba bersih

			$hutang = $this->db->select('SUM(totalhutang) as hutang')->from('hutang')->where('idpelanggan !=', '')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['hutang'] = $hutang->hutang;


			$pelunasan = $this->db->select('SUM(bayarhutang) as pelunasan')->from('hutang')->where('idpelanggan !=', '')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pelunasan'] = $pelunasan->pelunasan;



			
			//rinci piutang pelanggan
			$rincipiutang = $this->db->query("SELECT (SELECT namapelanggan From pelanggan WHERE idpelanggan=a.idpelanggan) AS namapelanggan, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idpelanggan = a.idpelanggan GROUP BY idpelanggan) AS sisahutang  FROM hutang AS a WHERE a.date >='".$dateSebelum."' AND a.date <='" .  $dateNow . "' AND a.idpelanggan !='' AND a.bayarhutang > 0 GROUP BY a.idpelanggan")->result();
			$data['rincibayarpiutang'] = $rincipiutang;



			//bayar hutang ke suplayer
			$bayarhutang = $this->db->select('SUM(bayarhutang) as bayarhutang')->from('hutang')->where('idsuplayer !=', '')->where('date >=', $dateSebelum)->where('date <=',$dateNow)->get()->row();
			$data['bayarhutang'] = $bayarhutang->bayarhutang;



			//sisa hutang ke suplayer
			$sisahutang = $this->db->query("SELECT SUM(sisa) AS sisa FROM (SELECT (SUM(hutang.totalhutang) - SUM(hutang.bayarhutang)) AS sisa FROM `hutang` JOIN suplayer on hutang.idsuplayer=suplayer.idsuplayer WHERE suplayer.idsuplayer !='' GROUP BY suplayer.idsuplayer) AS hutang")->row();
			$data['sisahutang'] = $sisahutang->sisa;

			// rinci hutang ke suplayer
			$rincihutang = $this->db->query("SELECT (SELECT namasuplayer From suplayer WHERE idsuplayer=a.idsuplayer) AS namasuplayer, SUM(a.bayarhutang) AS bayarhutang, a.kethutang,(SELECT (SUM(totalhutang) - SUM(bayarhutang)) AS sisahutang FROM `hutang` WHERE idsuplayer = a.idsuplayer GROUP BY idsuplayer) AS sisahutang  FROM hutang AS a WHERE a.date >='".$dateSebelum."' AND a.date <='" .  $dateNow . "' AND a.idsuplayer !='' AND a.bayarhutang > 0 GROUP BY a.idsuplayer")->result();
			$data['rincibayarhutang'] = $rincihutang;





			$pembelian = $this->db->select('SUM(totalharga) as totalpembelian')->from('header')->where('status', 'pmb')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pembelian'] = $pembelian->totalpembelian;

			$pengeluaran = $this->db->select('SUM(nominal)as totalpengeluaran')->from('pengeluaran')->where('date >=', $dateSebelum)->where('date <= ', $dateNow)->get()->row();
			$data['pengeluaran'] = $pengeluaran->totalpengeluaran;


			$data['jlmPembelian'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, suplayer.namasuplayer')->from('header')
				->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pmb')
				->group_by('header.idsuplayer')
				->order_by('header.totalharga', 'desc')
				->get()->result();




			$data['jlmPenjualan'] = $this->db->select('SUM(detail_header.qty) as totalqty, SUM(detail_header.totalharga) as totalharga, namapelanggan,  (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
				->join('detail_header', 'detail_header.idheader=header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('header.idpelanggan')
				->order_by('header.totalharga', 'desc')
				->get()->result();





			$data['pembelianBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pmb')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();

			$data['penjualanBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga, (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$data['banyakBarang'] = $this->db->select('detail_header.idbarang, SUM(detail_header.qty) as totalpcs, detail_header.t, detail_header.l, detail_header.p')->from('detail_header')
				->join('header', 'header.idheader=detail_header.idheader')
				->where('header.date >=', $dateSebelum)
				->where('header.date <= ', $dateNow)
				->where('header.status', 'pnj')
				->group_by('detail_header.idbarang', 'asc')
				->get()->result();


			$this->load->view('admin/dashboard/index', $data);
		}
	}
	public function laporanBarang()
	{
		if ($this->cekLevel()) {
			$tglP = $this->input->post('tglP', true);
			$tglK = $this->input->post('tglK', true);

			$data['tglP'] = $tglP;
			$data['tglK'] = $tglK;
			$data['data'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga,  (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba, SUM(detail_header.hargamodal*detail_header.qty) as hargamodal')->from('header')
				->join('detail_header', 'header.idheader=detail_header.idheader')
				->where('header.status', 'pnj')
				->where('header.date >=', (empty($tglP) ? date('Y-m-') . '01' : $tglP))
				->where('header.date <= ', (empty($tglK) ? date('Y-m-d') : $tglK))
				->group_by('detail_header.idbarang')
				->order_by('detail_header.date', 'DESC')
				->get()->result();
			$this->load->view('admin/dashboard/laporanBarang', $data);
		}
	}


	public function kasir()
	{
		$iduser = $this->session->userdata('iduser');
		$data['priode'] = date("Y-m-d");
		$tunai = $this->db->select('(SUM(totalharga-sisa)) as tunai')->from('header')->where('header.iduser', $iduser)->where('status', 'pnj')->where('date', date('Y-m-d'))->group_by('status')->get()->row();
		$data['tunai'] = (!empty($tunai->tunai) ? $tunai->tunai : 0);

		$hutang = $this->db->select('SUM(totalhutang) as hutang')->from('hutang')->where('idpelanggan !=', '')->where('iduser', $iduser)->where('date', date('Y-m-d'))->get()->row();
		$data['hutang'] = $hutang->hutang;

		$pelunasan = $this->db->select('SUM(bayarhutang) as pelunasan')->from('hutang')->where('iduser', $iduser)->where('idpelanggan !=', '')->where('date', date('Y-m-d'))->get()->row();
		$data['pelunasan'] = $pelunasan->pelunasan;

		$laba = $this->db->select('SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty) as laba')->from('header')
			->join('detail_header', 'detail_header.idheader=header.idheader')
			->where('header.status', 'pnj')
			->where('header.date', date('Y-m-d'))
			->get()->row();
		$diskon = $this->db->select('SUM(diskon) as diskon')->from('header')->where('status', 'pnj')->where('date', date('Y-m-d'))->get()->row();
		$data['laba'] = $laba->laba - $diskon->diskon;  //mencari laba bersih

		$pembelian = $this->db->select('SUM(totalharga) as totalpembelian')->from('header')->where('iduser', $iduser)->where('status', 'pmb')->where('date', date('Y-m-d'))->get()->row();
		$data['pembelian'] = $pembelian->totalpembelian;

		$pengeluaran = $this->db->select('SUM(nominal)as totalpengeluaran')->from('pengeluaran')->where('date', date('Y-m-d'))->get()->row();
		$data['pengeluaran'] = $pengeluaran->totalpengeluaran;



		$data['jlmPembelian'] = $this->db->select('SUM(detail_header.qty) as totalqty, (SUM(detail_header.totalharga) + SUM(header.transport + header.bongkar)) as totalharga, namasuplayer')->from('header')
			->join('suplayer', 'suplayer.idsuplayer=header.idsuplayer')
			->join('detail_header', 'detail_header.idheader=header.idheader')
			->where('iduser', $iduser)
			->where('header.date', date('Y-m-d'))
			->where('header.status', 'pmb')
			->group_by('header.idsuplayer')
			->order_by('header.totalharga', 'desc')
			->get()->result();




		$data['jlmPenjualan'] = $this->db->select('SUM(detail_header.qty) as totalqty, (SUM(detail_header.totalharga)- header.diskon) as totalharga, namapelanggan,  ((SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) - header.diskon) as laba')->from('header')
			->join('pelanggan', 'pelanggan.idpelanggan=header.idpelanggan')
			->join('detail_header', 'detail_header.idheader=header.idheader')
			->where('iduser', $iduser)
			->where('header.date', date('Y-m-d'))
			->where('header.status', 'pnj')
			->group_by('header.idpelanggan')
			->order_by('totalharga', 'desc')
			->get()->result();







		$data['pembelianBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga')->from('header')
			->join('detail_header', 'header.idheader=detail_header.idheader')
			->where('iduser', $iduser)
			->where('header.date', date('Y-m-d'))
			->where('header.status', 'pmb')
			->group_by('detail_header.idbarang', 'asc')
			->get()->result();


		$data['penjualanBarang'] = $this->db->select('detail_header.idbarang, detail_header.t, detail_header.l, detail_header.p, SUM(detail_header.qty) as totalpcs, SUM(detail_header.totalharga) as totalharga, (SUM((detail_header.hargasatuan-detail_header.hargamodal)*detail_header.qty)) as laba')->from('header')
			->join('detail_header', 'header.idheader=detail_header.idheader')
			->where('iduser', $iduser)
			->where('header.date', date('Y-m-d'))
			->where('header.status', 'pnj')
			->group_by('detail_header.idbarang', 'asc')
			->get()->result();




		$data['banyakBarang'] = $this->db->select('detail_header.idbarang, SUM(detail_header.qty) as totalpcs, detail_header.t, detail_header.l, detail_header.p')->from('detail_header')
			->join('header', 'header.idheader=detail_header.idheader')
			->where('iduser', $iduser)
			->where('header.date', date('Y-m-d'))
			->where('header.status', 'pnj')
			->group_by('detail_header.idbarang', 'asc')
			->get()->result();


		$this->template->displayFullAdmin('admin/dashboard/dashboardKasir', $data);
	}





}