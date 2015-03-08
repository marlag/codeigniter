<?php

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */

function get_user_id()
{
	$CI =& get_instance();
	return $CI->tank_auth->get_user_id();
}

function get_user_role()
{
	$CI =& get_instance();
	return $CI->permission->get_user_role();
}
