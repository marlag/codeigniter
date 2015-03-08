<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class APP_Router extends CI_Router {

    function set_method($method) {
        $this->method = str_replace( '-', '_', $method);
    }
}
