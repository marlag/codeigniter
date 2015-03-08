<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class APP_Model extends CI_Model {
    protected $ci;

    function __construct() {
		parent::__construct();
		$this->ci =& get_instance();
	}

    function get_by_id($id) {
        return $this->db->get_where($this->table_name, array('id' => (int)$id))->result_array();
    }
}
