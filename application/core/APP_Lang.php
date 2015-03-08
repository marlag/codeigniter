<?php

/**
 * @package marlag/codeigniter
 * @author Marcin L. <marlag@fr.pl>
 * @license MIT
 */
class APP_Lang extends CI_Lang {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Load a language file
     *
     * Reimplements reading file - parsing except including
     *
     * @param mixed  $langfile    Language file name
     * @param string $idiom       Language name (english, etc.)
     * @param bool   $return      Whether to return the loaded array of translations
     * @param bool   $add_suffix  Whether to add suffix to $langfile
     * @param string $alt_path    Alternative path to look for the language file
     *
     * @return    void|string[]    Array containing translations, if $return is set to TRUE
     */
    public function load($langname, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
        if (is_array($langname)) {
            foreach ($langname as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path);
            }
            return;
        }

        $langfile = \str_replace('.php', '', $langname);
        $found = FALSE;

        if ($add_suffix === TRUE) {
            $langfile = preg_replace('/_lang$/', '', $langfile).'_lang';
        }

        if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $idiom = get_cookie('language', true);
            if(false === $idiom) {
                $config =& get_config();
                $idiom = empty($config['language']) ? 'english' : $config['language'];
            }
        }

        if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
            return;
        }

        $entries = array();

        // Load the base file, so any others found can override it
        $basepath = BASEPATH.'language/'.$idiom.'/'.$langfile;
        if (file_exists($basepath.'.php') || file_exists($basepath.'.txt')) {
            $found = TRUE;
            $entries = $this->_readfile($basepath);
        }

        // Do we have an alternative path to look in?
        if ($alt_path !== '') {
            $alt_path .= 'language/'.$idiom.'/'.$langfile;
            if (file_exists($alt_path.'.php') || file_exists($alt_path.'.txt')) {
                $entries = array_merge( $entries, $this->_readfile($alt_path));
                $found = TRUE;
            }
        } else {
            foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
                $package_path .= 'language/'.$idiom.'/'.$langfile;
                if ($basepath !== $package_path && (file_exists($package_path.'.php') || file_exists($package_path.'.txt'))) {
                    $entries = array_merge( $entries, $this->_readfile($package_path));
                    $found = TRUE;
                    break;
                }
            }
        }

        if ($found !== TRUE) {
            if ('english' === $idiom) {
                show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile.'.php|txt');
            } else {
                log_message('error', 'Unable to load the requested language file: language/'.$idiom.'/'.$langfile.'.php|txt');
                return $this->load($langname, 'english', $return, $add_suffix, $alt_path);
            }
        }

        if ( ! isset($entries) OR ! is_array($entries)) {
            log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile.'.php|txt');

            if ($return === TRUE) {
                return array();
            }
            return;
        }

        if ($return === TRUE) {
            return $entries;
        }

        $this->is_loaded[$langfile] = $idiom;
        $this->language = array_merge($this->language, $entries);

        log_message('info', 'Language file loaded: language/'.$idiom.'/'.$langfile);
        return TRUE;
    }

    /**
     * Reads file from path - includes $lang defined in php files (original in CI)
     * or reads patterns from txt files:
     * lang:some-identifier: Lang entry, can be multiline
     *
     * @param string  $file   Language file name without extension
     *
     * @return string[]  Array containing translations
     */
    function _readfile($file) {
        $lang = array();
        if (file_exists($file.'.txt')) {
            $content = file_get_contents($file.'.txt');
            $entries = preg_split('/^lang:/m', $content);
            foreach($entries as $e) {
                if ($e) {
                    $l = explode(': ', $e);
                    $lang[array_shift($l)] = trim(implode(': ', $l));
                }
            }
        } else {
            include($file.'.php');
        }
        return $lang;
    }
}
