<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Set extends APP_Controller {

    function __construct() {
        parent::__construct();
        $this->_init('noauth');
    }

    function language($lang) {
        $langs = $this->config->item('languages');
        $lang = $this->uri->segment(3);
        $idiom = $langs[$lang];
        if($idiom) {
            $this->load->helper('cookie');
            set_cookie('language', $idiom, 365 * 24 * 3600);
        }
        $url = array_slice($this->uri->segment_array(), 3);
        redirect('/'.implode('/', $url));
    }
}
