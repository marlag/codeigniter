<?php

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class AppDebug {
    function call_method() {
        $CI =& get_instance();
        log_message('debug', 'URI called: '.$CI->uri->uri_string());
        if($_POST) {
            log_message('info', 'with POST: '.serialize($_POST));
        }
    }
}
