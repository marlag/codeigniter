<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
    'class'    => 'AppDebug',
    'function' => 'call_method',
    'filename' => 'AppDebug.php',
    'filepath' => 'hooks',
    'params'   => false
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'Permission',
    'function' => 'check_role',
    'filename' => 'Permission.php',
    'filepath' => 'libraries',
    'params'   => false
);
