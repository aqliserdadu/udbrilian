<?php
class Template {
	protected $_ci;
	
	function __construct()
		{
			$this->_ci=&get_instance();
		}
	
	function displayFullAdmin($template,$data=null)
	{
		$data['content'] = $this->_ci->load->view($template,$data,true);
		$this->_ci->load->view('template/templateAdmin',$data);
	}
	
	function displayFullStaf($template,$data=null)
	{
		$data['notif'] = $this->_ci->load->view('template/notifStaf',$data,true);
		$data['content'] = $this->_ci->load->view($template,$data,true);
		$this->_ci->load->view('template/templateStaf',$data);
	}
	
	
	function displayFullMember($template,$data=null)
	{
		$data['notif'] = $this->_ci->load->view('template/notifMember',$data,true);
		$data['content'] = $this->_ci->load->view($template,$data,true);
		$this->_ci->load->view('template/templateMember',$data);
	}
	
	
	
	
}
