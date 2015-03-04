<?php

class MY_Loader extends CI_Loader{

	function __construct(){
		parent::__construct();
	}

	
	public function model($model, $name = '', $db_conn = FALSE)
	{
		// save the user's model path 
		$userModel = $model ;

		if (empty($model))
		{
			return $this;
		}
		elseif (is_array($model))
		{
			foreach ($model as $key => $value)
			{
				is_int($key) ? $this->model($value, '', $db_conn) : $this->model($key, $value, $db_conn);
			}

			return $this;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, ++$last_slash);

			// And the model name behind it
			$model = substr($model, $last_slash);
		}

		if (empty($name))
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return $this;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		if ($db_conn !== FALSE && ! class_exists('CI_DB', FALSE))
		{
			if ($db_conn === TRUE)
			{
				$db_conn = '';
			}

			$this->database($db_conn, FALSE, TRUE);
		}

		if ( ! class_exists('CI_Model', FALSE))
		{
			load_class('Model', 'core');
		}

		$model = ucfirst(strtolower($model));

		/* My Changes*/
		
		$ci = get_instance(); // CI_Loader instance
		$hmvc_paths = $ci->config->item('hmvc_paths');
		$class = $ci->router->class;
		$userModel = explode('/', $userModel);

		foreach($hmvc_paths as $key => $value){
			$hmvc_paths[$key] =  APPPATH . $value . $class . '/';

			if(is_array($userModel)){
				$hmvc_paths[] =  APPPATH . $value ;//.  $userModel[0] . '/';	
			}
			
		}

		

		
		$this->_ci_model_paths = array_merge($this->_ci_model_paths, $hmvc_paths);
		/* End My changes */

		foreach ($this->_ci_model_paths as $mod_path)
		{
			if(is_array($userModel)){
				if ( ! file_exists($mod_path.$path.'models/' .$model.'.php')){
					continue;
				}
			}else{
				if ( ! file_exists($mod_path.'models/'.$path.$model.'.php')){
					continue;
				}
			}
			
			if(is_array($userModel)){
				require_once($mod_path.$path.'models/'.$model.'.php');
			}else{
				require_once($mod_path.'models/'.$path.$model.'.php');
			}
			

			$this->_ci_models[] = $name;
			$CI->$name = new $model();
			return $this;
		}

		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}

	// -----------------------------------------------------------------------
	/**
	 * View Loader
	 *
	 * Loads "view" files.
	 *
	 * @param	string	$view	View name
	 * @param	array	$vars	An associative array of data
	 *				to be extracted for use in the view
	 * @param	bool	$return	Whether to return the view output
	 *				or leave it to the Output class
	 * @return	object|string
	 */
	public function view($view, $vars = array(), $return = FALSE)
	{
		
		$userViewName = explode("/", $view);
		$ci = get_instance(); // CI_Loader instance
		$hmvc_paths = $ci->config->item('hmvc_paths');

		$tempControllerName = '';
		$tempViewName = '';

		if(count($userViewName) > 1){
			$tempControllerName = $userViewName[0];
			array_shift($userViewName);
			$tempViewName = implode('/', $userViewName);
			unset($userViewName);
		}
		

		foreach($hmvc_paths as $path){

			if(file_exists(APPPATH.$path.$ci->router->class.'/views/'.$view.'.php')){
				$this->_ci_view_paths[APPPATH.$path.$ci->router->class.'/views/'] = true;
				break;	
			}

			if($tempControllerName != ''){

				if(file_exists(APPPATH.$path.$tempControllerName.'/'.$tempViewName.'.php')){
					$this->_ci_view_paths[APPPATH.$path.$tempControllerName .'/'] = true;
					$view = $tempViewName;
					break;	
				}

			}

		}
		
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}


}