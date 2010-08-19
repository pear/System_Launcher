<?php
/**
 * Launch files with the associated application.
 *
 * PHP version 5
 * 
 * @category File
 * @package  File_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.1.0
 */

/**
 * Mac OS X driver
 * 
 * @category File
 * @package  File_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.1.0
 */
class File_Launcher_Driver_Mac implements File_Launcher_Driver
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
        return 'open %s';
    }
    
    /**
     * Returns true if this class applies to the current OS.
     * 
     * @return boolean
     */
    public function applies()
    {
        return strstr(PHP_OS, 'Darwin');
    }
}

