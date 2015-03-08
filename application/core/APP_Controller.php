<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class APP_Controller extends CI_Controller {
    var $view_variables = array();

    function __construct() {
        parent::__construct();
    }

    function _init($authorize = 'auth') {
        $this->load->library('tank_auth');
        if ('auth' == $authorize && false == $this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function _assign( $name, $value = null) {
        if( is_array( $name) && null === $value) {
            foreach( $name as $k => $v) {
              $this->view_variables[$k] = $v;
            }
        } else {
            $this->view_variables[$name] = $value;
        }
    }

  function _view( $view, $return = false) {
        if($return) {
            return $this->load->view( $view, $this->view_variables, true);
        }
        
        $this->view_variables['assets'] = $this->config->item('assets');
        $this->load->view('header', $this->view_variables);
        $this->load->view('menu', $this->view_variables);
        $this->load->view($view, $this->view_variables);
        $this->load->view('footer', $this->view_variables);
    }
}
