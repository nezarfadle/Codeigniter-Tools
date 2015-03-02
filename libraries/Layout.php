<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout{

	private $layout = array();
	protected $CI;

	function __construct(){
		$this->CI =& get_instance();
		$this->CI->config->load('layout');
	}

	public function view($tpl, $data = null, $returnView = false){
		return @$this->CI->load->view($tpl, $data, $returnView);
	}

	public function render($tpl = null, $data = null){
		
		$layout_path = $this->CI->config->item('layout_path');
		$default_page = $layout_path . $this->CI->config->item('default_page');

		if(file_exists($default_page)){
				$this->layout['buffer'] = @$this->CI->load->view($tpl, $data, true);
				
				if(is_array($data)){
					extract($data);
				}
				
				include_once $default_page ;
		}
		

	}
	
}
