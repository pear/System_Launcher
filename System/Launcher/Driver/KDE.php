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
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.1.0
 */

/** Driver base class */
require_once 'System/Launcher/Driver.php';

/**
 * KDE driver
 *  
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.1.0
 */
class System_Launcher_Driver_KDE implements File_Launcher_Driver
{
    /**
     * Returns a command string template usable with sprintf.
     * 
     * @param boolean $runInBackground Unused
     * 
     * @return Command string template to open something
     */
    public function getCommand($runInBackground)
    {
        return 'kfmclient exec %s';
    }
    
    /**
     * Returns true if this class applies to the current OS.
     * 
     * @return boolean
     */
    public function applies()
    {
        return (isset($_ENV['KDE_FULL_SESSION']) &&
            $_ENV['KDE_FULL_SESSION'] == 'true'
        );
    }
}
