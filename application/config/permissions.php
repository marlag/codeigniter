<?php

/*
 * Defines roles based access to controller/action
 */
$config['permissions']['roles'] = array(
    'welcome/index'       => FALSE, // any
    'welcome/other'       => ['admin', 'reader']
);

