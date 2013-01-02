<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Launch files with the associated application.
 *
 * usage:
 *   require_once 'System/Launcher.php';
 *   $launcher = new System_Launcher;
 *   $launcher->launch('/data/docs/index.html', true);
 *
 *   Commands
 *   --------
 *   Windows:        start <filename>
 *   Linux
 *       KDE         kfmclient exec <filename>
 *       Portland    xdg-open <filename>
 *       Gnome       gnome-open <filename>
 *   Mac OSX         open <filename>
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

/** Exception */
require_once 'Launcher/Exception.php';
/** Driver */
require_once 'Launcher/Driver.php';
/** Driver for GNOME */
require_once 'Launcher/Driver/GNOME.php';
/** Driver for KDE */
require_once 'Launcher/Driver/KDE.php';
/** Driver for Mac */
require_once 'Launcher/Driver/Mac.php';
/** Driver for Portland */
require_once 'Launcher/Driver/Portland.php';
/** Driver for Windows */
require_once 'Launcher/Driver/Windows.php';

/**
 * Launches files with the associated application.
 *
 * @category  System
 * @package   System_Launcher
 * @author    Christian Weiske <cweiske@php.net>
 * @author    Olle Jonsson <olle.jonsson@gmail.com>
 * @copyright 1997-2005 Christian Weiske
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL
 * @version   Release: 0.5.1
 * @link      http://github.com/olleolleolle/System_Launcher
 */
class System_Launcher
{
    /**
    * The driver for detected operating system.
    * @var object
    */
    protected $os;

    /**
    * Ordered list of drivers to test.
    * @var array
    */
    protected $drivers;

    /**
    * Command output string
    * @var string
    */
    protected $lastOutput;
    /**
     * Sets up a list of operating system checkers.
     *
     * @param array $drivers List of System_Launcher_Driver checkers.
     */
    public function __construct($drivers=null)
    {
        if ($drivers === null) {
            $this->drivers = array(
                new System_Launcher_Driver_Windows,
                new System_Launcher_Driver_Portland,
                new System_Launcher_Driver_KDE,
                new System_Launcher_Driver_GNOME,
                new System_Launcher_Driver_Mac
            );
        } else {
            $this->drivers = $drivers;
        }
    }

    /**
     * Tries to detect the current operating system and set its driver.
     *
     * @return void
     */
    protected function detectOS()
    {
        foreach ($this->drivers as $driver) {
            if ($driver->applies()) {
                $this->os = $driver;
                return;
            }
        }
        throw new System_Launcher_Exception("Unsupported OS.");
    }

    /**
     * Returns the appropriate command to launch the given file name,
     * depending on the operating system and the desktop environment.
     *
     * @param boolean $runInBackground True if the application should be run in the
     *   background
     *
     *   @return string    The command to execute
     */
    protected function getCommand($runInBackground)
    {
        $this->detectOS();
        $commandTemplate = $this->os->getCommand($runInBackground);
        if ($commandTemplate === '') {
            throw new System_Launcher_Exception('Command must not be empty.');
        }
        return $commandTemplate;
    }

    /**
     * Launches a file or URL with its associated application.
     *
     * @param string  $fileName        The file or URL to open
     * @param boolean $runInBackground True if the application should be run in the
     * background
     *
     * @return boolean   True if all was ok, false if there has been a problem
     */
    public function launch($fileName, $runInBackground=false)
    {
        $command = sprintf(
            $this->getCommand($runInBackground), $this->cleanFileName($fileName)
        );
        exec($command, $this->lastOutput, $status);
        return $status === 0;
    }

    /**
     * Removes initial dashes to avoid injection of command parameters.
     *
     * @param string $fileName Possibly malicious filename
     *
     * @return string Cleaned filename
     */
    protected function cleanFilename($fileName)
    {
        $fileName = preg_replace('%^-+%', '', $fileName);
        return escapeshellarg($fileName);
    }

    /**
     * Launches a file or URL in the background.
     *
     * @param string $fileName The file or URL to open
     *
     * @return boolean True if all was ok, false if there has been a problem
     */
    public function launchInBackground($fileName)
    {
        return $this->launch($fileName, true);
    }


    /**
     * Returns last command output as lines of text.
     *
     * @return array
     */
    public function getLastOutput()
    {
        return $this->lastOutput;
    }


}
