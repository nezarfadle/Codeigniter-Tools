<?php


class MY_Router extends CI_Router{

	function __construct(){
		parent::__construct();
		// $this->directory = "..\\modules\\posts\\controllers\\";
		// $this->directory = "../modules/posts/controllers/";

	}
		
	

	protected function _set_request($segments = array())
	{
		
		
		$segments = $this->_validate_request($segments);
		// If we don't have any segments left - try the default controller;
		// WARNING: Directories get shifted out of the segments array!
		if (empty($segments))
		{
			$this->_set_default_controller();
			return;
		}

		if ($this->translate_uri_dashes === TRUE)
		{
			$segments[0] = str_replace('-', '_', $segments[0]);
			if (isset($segments[1]))
			{
				$segments[1] = str_replace('-', '_', $segments[1]);
			}
		}

		$this->set_class($segments[0]);
		
		$hmvc_paths =  $this->config->item('hmvc_paths');

		if(is_array($hmvc_paths)){
			foreach($hmvc_paths as $path){
				// echo APPPATH . $path . $this->class . '/controllers/' . $this->class. '.php' . '<br>';

				if(file_exists(APPPATH  . $path . $this->class . '/controllers/' . $this->class. '.php')){
					// $this->directory = "../modules/posts/controllers/";
					$this->directory = '../' . $path. $this->class . '/controllers/' ;
					break;
				}
			}
		}

		if (isset($segments[1]))
		{
			$this->set_method($segments[1]);
		}
		else
		{
			$segments[1] = 'index';
		}

		array_unshift($segments, NULL);
		unset($segments[0]);
		
		$this->uri->rsegments = $segments;
	}


}