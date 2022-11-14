<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MProduk extends CI_Model {



function viewFrame()
	{

		$db = $this->db->select('*')->from('frame')->join('warnaFrame','warnaFrame.kodeWarna=frame.kodeWarna')->get()->result();
		
		return $db;
	}








}