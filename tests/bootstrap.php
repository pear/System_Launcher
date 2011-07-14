<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PHPUnit bootstrap
 *
 * PHP version 5
 * 
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.5.4
 */
$parent_folder = dirname(__FILE__) . '/..';
$system_folder = $parent_folder . '/System';
if (is_dir($system_folder)) {
    set_include_path($parent_folder . PATH_SEPARATOR . get_include_path());
}
