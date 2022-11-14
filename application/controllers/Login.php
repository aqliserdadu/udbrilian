<?php

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{



		$this->load->view('login');
	}

	function aksiLogin()
	{
		$user = $this->input->post('username', true);
		$password = $this->input->post('password', true);
		$cP = $password . "@ql153Rd@dU";  //kode @ql153Rd@dU adalah tambahan pengaman password

		$cek = $this->db->where('username', $user)->get("user")->num_rows();

		if ($cek > 0) {

			$status = $this->db->where('username', $user)->get("user")->row();

			if ($status->status == 1)  // status 1 aktif, 0 status off
			{

				$data = $this->db->where("username", $user)->get("user")->row();
				if (password_verify($cP, $data->password)) {
					$data_session = array(

						"iduser" => $data->iduser,
						"username" => $data->username,
						"gender" => $data->gender,
						"level" => $data->level,
						"status" => "login",

					);

					$this->session->set_userdata($data_session);

					$this->prosesSinkron();

					if ($data->level == 'admin') {
						redirect(base_url("dashboard"));
					} else {
						redirect(base_url("kasir"));
					}
				} else {
					echo $this->session->set_flashdata("massage", "<div class=alert-danger align='center'> Password Yang Anda Masukan Salah!!! </div>");
					redirect(base_url('Login'));
				}
			} else if ($status->stt == 0) {

				echo $this->session->set_flashdata("massage", "<div class=alert-danger align='center'> Maaf Akun Anda Tidak Aktif, Hub Admin!!! </div>");
				redirect(base_url('Login'));
			}
		} else {

			echo $this->session->set_flashdata("massage", "<div class=alert-danger align='center'> Username Yang Anda Masukan Salah!!! </div>");
			redirect(base_url('Login'));
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('Login'));
	}


	function prosesSinkron()
	{

		$cek = $this->db->select('*')
			->from('sinkronstok')
			->join('header', 'header.idheader=sinkronstok.idheader')
			->join('detail_header', 'detail_header.idheader=sinkronstok.idheader')
			->like('sinkronstok.tanggal', date('Y-m'))
			->get()->num_rows();

		if (empty($cek)) {

			$dateNow = date('Y-m-d');

			//cek apakah ada stock opname dibulan berjalan
			//jika ada perhitungan di mulai tgl stock opname

			$kode = "STOCKOPNAME" . date('Ym', strtotime('-1 month', strtotime($dateNow)));;
			$cek = $this->db->where('idheader', $kode)->get('header')->row();
			if (!empty($cek)) {

				$dateMulai = $cek->date;
			} else {

				$dateMulai = date('Y-m', strtotime('-1 month', strtotime($dateNow)));
				$dateMulai = $dateMulai . "-01";
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

				$pecah = explode('|', $this->stokmasuk($t->idbarang, $date, $dateMulai));
				$qty_masuk = $pecah[0];
				$totalharga = $pecah[1];
				$qty_keluar = $this->stokkeluar($t->idbarang, $date, $dateMulai);

				$qtysisa = ($qty_masuk - $qty_keluar);
				$m3 = ($t->t * $t->l * $t->p * $qtysisa) / 1000000;
				$hargasatuan = round($totalharga / $qty_masuk, 2);


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
				echo $this->session->set_flashdata("massage", "<script> alert('Sinkron Gagal!!! Lakukan Manual!!!')</script>");
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
				echo $this->session->set_flashdata("massage", "<script> alert('Sinkron Gagal!!! Lakukan Manual!!!')</script>");
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
			echo $this->session->set_flashdata("massage", "<script> alert('Sinkron Berhasil!!! Lakukan Verifikasi!!!')</script>");
		}
	}

	public function updateDbSinkron($data, $where)
	{

		return	$this->db->update('sinkronstok', $data, $where);
	}

	function stokmasuk($idbarang, $date, $dateMulai)
	{

		$qty = $this->db->select('SUM(detail_header.qty) as qty_masuk, SUM(detail_header.totalharga) as totalharga')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status !=', 'pnj')->where('header.date >=', $dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', $date)->get()->row();
		return (!empty($qty->qty_masuk) ? $qty->qty_masuk : 0) . "|" . (!empty($qty->totalharga) ? $qty->totalharga : 0);
	}


	function stokkeluar($idbarang, $date, $dateMulai)
	{

		$qty = $this->db->select('SUM(detail_header.qty) as qty_keluar')->from('header')->join('detail_header', 'detail_header.idheader=header.idheader')->where('header.status', 'pnj')->where('header.date >=', $dateMulai)->where('detail_header.idbarang', $idbarang)->like('detail_header.date', $date)->get()->row();
		return (!empty($qty->qty_keluar) ? $qty->qty_keluar : 0);
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
}
