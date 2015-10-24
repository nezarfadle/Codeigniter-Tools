<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

        public function view($tpl, $data = null, $returnView = false){

                if(file_exists(APPPATH . '/views/' . $tpl . '.php')){

                        if($data !== null && is_array($data)){
                                extract($data);
                        }

                        ob_start();
                        include APPPATH . 'views/' . $tpl . '.php';

                        if(!$returnView){
                                ob_end_flush();
                        }else{
                                $buffer = ob_get_clean();
                                return $buffer;
                        }

                }

        }

}