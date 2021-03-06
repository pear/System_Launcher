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

/**
 * Interface for OS and desktop command sources.
 *
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.1.0 
 */
interface System_Launcher_Driver
{
    /**
     * What is the opener command? 
     *
     * @param boolean $runInBackground Should this window be a background
     * window?
     * 
     * @return Command template usable with sprintf
     */
    public function getCommand($runInBackground);
    /**
     * Does this apply to the current operating system?
     *
     * @return true if this class applies to current OS
     */
    public function applies();
}
