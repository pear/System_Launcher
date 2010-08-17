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
 * @
 */


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
    *   Operating system constants.
    */
    protected static $OS_LINUX       = 0;
    protected static $OS_WINDOWS     = 1;
    protected static $OS_MAC         = 2;

    /**
    *   Desktop environment constants.
    */
    protected static $DE_LINUX_KDE   = 0;
    protected static $DE_LINUX_GNOME = 1;
    protected static $DE_LINUX_PORTLAND = 2;

    /**
    *   The detected operating system.
    *   @var    int
    */
    protected $nCurrentOS     = null;

    /**
    *   The detected desktop environment.
    *   @var    int
    */
    protected $nCurrentDE     = null;



    /**
    *   Initializes the class variables.
    */
    public function __construct()
    {
        $this->nCurrentOS = $this->detectOS();
    }//public function __construct()



    /**
    *   Tries to detect the current operating system.
    *
    *   @return    int        The current operating system constant
    */
    protected function detectOS()
    {
        if (strstr(PHP_OS, 'Linux')) {
            $this->nCurrentDE = $this->detectDE(self::$OS_LINUX);
            return self::$OS_LINUX;
        } else if (strstr(PHP_OS, 'WIN')) {
            return self::$OS_WINDOWS;
        } else {
            return self::$OS_MAC;
        }
        return false;
    }//protected function detectOS()

    /**
    * Tries to detect presence of Portland.
    * 
    * @return success
    */
    protected function detectPortland()
    {
        exec("which -s xdg-open", $skippedOutput, $status);
        return $status === 0;
    }

    /**
    *   Tries to detect the current desktop environment.
    *
    *   @param int $nCurrentOS The operating system for which the desktop
    *   environment shall be detected
    * 
    *   @return int  The current desktop environment constant
    */
    protected function detectDE($nCurrentOS)
    {
        switch ($nCurrentOS)
        {
        case self::$OS_LINUX:
            if ($this->detectPortland()) {
                return self::$DE_LINUX_PORTLAND;
            } else if (isset($_ENV['KDE_FULL_SESSION']) 
                && $_ENV['KDE_FULL_SESSION'] == 'true'
            ) {
                return self::$DE_LINUX_KDE;
            } else {
                return self::$DE_LINUX_GNOME;
            }
            break;
        }
        return false;
    }//protected function detectDE( $nCurrentOS)



    /**
    *   Returns the appropriate command to launch the
    *   given file name, depending on the operating
    *   system and the desktop environment.
    *
    *   @param string  $strFilename The file to open
    *   @param boolean $bBackground True if the application should be run in the
    *   background
    *
    *   @return string    The command to execute
    */
    protected function getCommand($strFilename, $bBackground)
    {
        $strBackground = '';
        switch ($this->nCurrentOS)
        {
        case self::$OS_WINDOWS:
            //the first "" is the title for the window
            //automatically in background
            if (!$bBackground) {
                $strBackground    = ' /WAIT';
            }
            return 'start ""' . $strBackground . ' ' . escapeshellarg($strFilename);
            break;

        case self::$OS_MAC:
            return 'open ' . escapeshellarg($strFilename);
            break;

        case self::$OS_LINUX:
            switch ($this->nCurrentDE)
            {
            case self::$DE_LINUX_KDE:
                //automatically in background
                return 'kfmclient exec ' . escapeshellarg($strFilename);
                break;
            case self::$DE_LINUX_GNOME:
                //automatically in background
                return 'gnome-open ' . escapeshellarg($strFilename);
                break;
            case self::$DE_LINUX_PORTLAND:
                //automatically in background
                return 'xdg-open ' . escapeshellarg($strFilename);
                break;
            default:
                trigger_error(
                    'FileLauncher: Unknown linux desktop environment "' . 
                    $this->nCurrentDE . '".', E_USER_NOTICE
                );
                break;
            }
            break;
        default:
            trigger_error(
                'FileLauncher: Unknown operating system "' . 
                $this->nCurrentOS . '".', E_USER_NOTICE
            );
            break;
        }
        return false;
    }//protected function getCommand($strFilename)



    /**
    * Launches a file.
    *
    * @param string  $strFilename The file to open
    * @param boolean $bBackground True if the application should be run in the
    * background
    *
    * @return boolean   True if all was ok, false if there has been a problem
    */
    public function launch($strFilename, $bBackground = true)
    {
        $strCommand  = $this->getCommand($strFilename, $bBackground);

        $arOutput    = array();
        $nReturnVar  = 0;
        exec($strCommand, $arOutput, $nReturnVar);

        return $nReturnVar == 0;
    }//public function launch($strFilename, $bBackground = true)



    /**
    *   Convenience method to launch a file in background.
    *
    *   @param string $strFilename Filename to open
    *
    *   @return boolean True if all was ok
    */
    public static function launchBackground($strFilename)
    {
        $fl = new File_Launcher();
        return $fl->launch($strFilename, true);
    }//public static function launchBackground($strFilename)



    /**
    *   Convenience method to launch a file in foreground.
    *   (Wait until the program is ended)
    *
    *   @param string $strFilename Filename to open
    * 
    *   @return boolean True if all was ok
    */
    public static function launchFile($strFilename)
    {
        $fl = new File_Launcher();
        return $fl->launch($strFilename, false);
    }//public static function launchFile($strFilename)

}//class FileLauncher
?>