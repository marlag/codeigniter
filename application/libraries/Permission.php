<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class Permission {

    private $ci;

	public function __construct() {
		$this->ci =& get_instance();		
    }

    public function get_user_role() {
        $this->ci->load->library('tank_auth');
        if(false == $this->ci->session->userdata('role')) {
            $user = $this->ci->users->get_user_by_id($this->ci->tank_auth->get_user_id(), TRUE);
            $this->ci->session->set_userdata('role', $user->role);
        }

        return $this->ci->session->userdata('role');
    }

    public function check_role() {
        $entry = $this->ci->uri->rsegment(1).'/'.$this->ci->uri->rsegment(2);
        $perms = $this->ci->config->item('roles', 'permissions');
        if(isset($perms[$entry]) && is_array($perms[$entry])) {
            $role = $this->get_user_role();
            if(false == in_array($role, $perms[$entry])) {
                show_error('Role permission denied');
            }
        }
    }
}

