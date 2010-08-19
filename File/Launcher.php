<?php
/**
 * Launch files with the associated application.
 *
 * usage:
 *   require_once 'File/Launcher.php';
 *   File_Launcher::launchBackground('/data/docs/index.html');
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
 * @category File
 * @package  File_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.1.0
 */

/** PEAR exceptions */
require_once 'PEAR/Exception.php';


/**
 * Launches files with the associated application.
 *
 * @category  File
 * @package   File_Launcher
 * @author    Christian Weiske <cweiske@php.net>
 * @author    Olle Jonsson <olle.jonsson@gmail.com>
 * @copyright 1997-2005 Christian Weiske
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL
 * @version   Release: 0.5.1
 * @link      http://github.com/olleolleolle/File_Launcher
 */
class File_Launcher
{
    /**
    *   The detected operating system.
    *   @var    int
    */
    protected $os;

    /**
    *   Initializes the class variables.
    */
    public function __construct()
    {
        $this->drivers = array(
            new File_Launcher_Windows,
            new File_Launcher_KDE,
            new File_Launcher_GNOME,
            new File_Launcher_Portland,
            new File_Launcher_Mac
        );
    }//public function __construct()

    /**
     * Tries to detect the current operating system.
     *
     * @return int The current operating system constant
     */
    protected function detectOS()
    {
        foreach ($this->drivers as $driver) {
            if ($driver->applies()) {
                $this->os = $driver;
                return;
            }
        }
        throw new PEAR_Exception("Unsupported OS.");
        
    }//protected function detectOS()

    /**
     *   Returns the appropriate command to launch the
     *   given file name, depending on the operating
     *   system and the desktop environment.
     *
     *   @param string  $fileName The file to open
     *   @param boolean $runInBackground True if the application should be run in the
     *   background
     *
     *   @return string    The command to execute
     */
    protected function getCommand($runInBackground)
    {
        $this->detectOS();
        return $this->os->getCommand($runInBackground);
    }//protected function getCommand($fileName)

    /**
     * Launches a file.
     *
     * @param string  $fileName The file to open
     * @param boolean $runInBackground True if the application should be run in the
     * background
     *
     * @return boolean   True if all was ok, false if there has been a problem
     */
    public function launch($fileName, $runInBackground=false)
    {
        $command = sprintf($this->getCommand($runInBackground), $fileName);
        exec($command, $skippedOutput, $status);
        return $status === 0;
    }//public function launch($fileName, $runInBackground = true)



    /**
     * Convenience method to launch a file in background.
     *
     * @param string $fileName Filename to open
     *
     * @return boolean True if all was ok
     */
    public static function launchBackground($fileName)
    {
        $fl = new File_Launcher();
        return $fl->launch($fileName, true);
    }//public static function launchBackground($fileName)



    /**
     * Convenience method to launch a file in foreground.
     * (Wait until the program is ended)
     *
     * @param string $fileName Filename to open
     * 
     * @return boolean True if all was ok
     */
    public static function launchFile($fileName)
    {
        $fl = new File_Launcher();
        return $fl->launch($fileName, false);
    }//public static function launchFile($fileName)

}//class FileLauncher


interface File_Launcher_Driver {
    /** What's the command to launch things? */
    public function getCommand($runInBackground);
    /** Does this apply to the current operating system? */
    public function applies();
}

class File_Launcher_Windows implements File_Launcher_Driver {
    /**
     * @return Command string template to open something
     */
    public function getCommand($runInBackground) {
        if ($runInBackground)
            return 'start "" /WAIT %s';
        else
            return 'start "" %s';
    }
    
    /**
     * @return Does this apply to the current operating system?
     */
    public function applies() {
        return strstr(PHP_OS, 'WIN');
    }
}

class File_Launcher_Mac implements File_Launcher_Driver {
    /**
     * @return Command string template to open something
     */
    public function getCommand($runInBackground) {
        return 'open %s';
    }
    
    /**
     * @return Does this apply to the current operating system?
     */
    public function applies() {
        // How can we tell it's a Mac?
        return true;
    }
}

class File_Launcher_Portland implements File_Launcher_Driver {
    /**
     * @return Command string template to open something
     */
    public function getCommand($runInBackground) {
        return 'xdg-open %s';
    }
    
    /**
     * @return Does this apply to the current operating system?
     */
    public function applies() {
        if (!strstr(PHP_OS, 'Linux')) {
            return false;
        }
        exec("which -s xdg-open", $skippedOutput, $status);
        return $status === 0;
    }
}

class File_Launcher_KDE implements File_Launcher_Driver {
    /**
     * @return Command string template to open something
     */
    public function getCommand($runInBackground) {
        return 'kfmclient exec %s';
    }
    
    /**
     * @return Does this apply to the current operating system?
     */
    public function applies() {
        return strstr(PHP_OS, 'Linux') && 
            (isset($_ENV['KDE_FULL_SESSION']) &&
            $_ENV['KDE_FULL_SESSION'] == 'true'
        );
    }
}

class File_Launcher_GNOME implements File_Launcher_Driver {
    /**
     * @return Command string template to open something
     */
    public function getCommand($runInBackground) {
        return 'gnome-open %s';
    }
    
    /**
     * @return Does this apply to the current operating system?
     */
    public function applies() {
        
        return strstr(PHP_OS, 'Linux') &&
            isset($_ENV['GNOME_DESKTOP_SESSION_ID']);
    }
}

?>