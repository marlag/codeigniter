<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends APP_Controller {

    function __construct() {
        parent::__construct();
        $this->_init();
    }

    public function index() {
        
        $this->_view('welcome');
    }
}
