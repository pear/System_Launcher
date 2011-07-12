<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Launch files with the associated application.
 *
 * PHP version 5
 * 
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.1.0
 */

/** Driver base class */
require_once 'System/Launcher/Driver.php';

/**
 * Windows driver
 * 
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.1.0
 */
class System_Launcher_Driver_Windows implements File_Launcher_Driver
{
    /**
     * Returns a command string template usable with sprintf.
     * 
     * @param boolean $runInBackground Set to true to open in background
     * 
     * @return Command string template to open something
     */
    public function getCommand($runInBackground)
    {
        if ($runInBackground) {
            return 'start "" /WAIT %s';
        } else {
            return 'start "" %s';
        }
    }
    
    /**
     * Returns true if this class applies to the current OS.
     * 
     * @return boolean
     */
    public function applies()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
