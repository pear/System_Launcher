<?php
/**
*   launch files with the associated application
*   @author Christian Weiske <cweiske@php.net>
*
*   You may use this script the way you like
*   in your own non-commercial programs.
*   The only condition is that the author
*   note and this text stays untouched.
*
*   usage:
*   require_once('File/Launcher.php');
*   launch_file_background('/data/docs/index.html');
*
*   Commands
*   --------
*   Windows:        start <filename>
*   Linux
*       KDE         kfmclient exec <filename>
*       Gnome       gnome-open <filename>
*   Mac OSX         open <filename>
*/



/**
*   opens the appropriate application
*   with the given file name and waits
*   until it has exited
*
*   Note:
*   On linux (gnome+kde) it will
*   be automatically launched in the
*   background, without any chance to
*   wait
*   - on windows you can switch between background and waiting
*
*   @param  string   the file to open
*
*   @return boolean  True if all was ok
*/
function launch_file( $strFilename)
{
    $fl    = new File_Launcher();
    return $fl->launch_file( $strFilename, false);
}//function launch_file( $strFilename)



/**
*   opens the appropriate application
*   with the given file name and returns
*   immediately
*
*   @param  string   the file to open
*
*   @return boolean  True if all was ok
*/
function launch_file_background( $strFilename)
{
    $fl    = new File_Launcher();
    return $fl->launch_file( $strFilename, true);
}//function launch_file_background( $strFilename)



/**
*   launches files with the associated application
*   @author Christian Weiske <cweiske@php.net>
*/
class File_Launcher
{
    /**
    *   operating system constants
    */
    var $OS_LINUX       = 0;
    var $OS_WINDOWS     = 1;
    var $OS_MAC         = 2;

    /**
    *   desktop environment constants
    */
    var $DE_LINUX_KDE   = 0;
    var $DE_LINUX_GNOME = 1;

    /**
    *    The detected operating system 
    *    @var    int
    */
    var $nCurrentOS     = null;

    /**
    *    The detected desktop environment
    *    @var    int
    */
    var $nCurrentDE     = null;



    /**
    *    constructor
    *    initializes the class variables
    */
    function FileLauncher()
    {
        $this->nCurrentOS = $this->detect_os();
    }//function FileLauncher()



    /**
    *    tries to detect the current operating system
    *    @return    int        The current operating system constant
    */
    function detect_os()
    {
        if (strstr(PHP_OS, 'Linux')) {
            $this->nCurrentDE = $this->detect_de($this->OS_LINUX);
            return $this->OS_LINUX;
        } else if (strstr(PHP_OS, 'WIN')) {
            return $this->OS_WINDOWS;
        } else {
            return $this->OS_MAC;
        }
        return false;
    }//function detect_os()



    /**
    *    tries to detect the current desktop environment
    *
    *    @param  int  The operating system for which the desktop environment shall be detected
    *    @return int  The current desktop environment constant
    */
    function detect_de($nCurrentOS)
    {
        switch ($nCurrentOS)
        {
            case $this->OS_LINUX:
                if (isset($_ENV['KDE_FULL_SESSION']) && $_ENV['KDE_FULL_SESSION'] == 'true') {
                    return $this->DE_LINUX_KDE;
                } else {
                    return $this->DE_LINUX_GNOME;
                }
                break;
        }
        return false;
    }//function detect_de( $nCurrentOS)



    /**
    *    returns the appropriate command to launch the
    *    given file name, depending on the operating
    *    system and the desktop environment
    *
    *    @param  string    The file to open
    *    @param  boolean   True if the application should be run in the background
    *
    *    @return string    The command to execute
    */
    function get_command($strFilename, $bBackground)
    {
        $strBackground    = '';
        switch ($this->nCurrentOS)
        {
            case $this->OS_WINDOWS:
                //the first "" is the title for the window
                //automatically in background
                if (!$bBackground) {
                    $strBackground    = ' /WAIT';
                }
                return 'start ""' . $strBackground . ' "' . $strFilename . '"';
                break;
            
            case $this->OS_MAC:
                return 'open "' . $strFilename . '"';
                break;
            
            case $this->OS_LINUX:
                switch ($this->nCurrentDE)
                {
                    case $this->DE_LINUX_KDE:
                        //automatically in background
                        return 'kfmclient exec "' . $strFilename . '"';
                        break;
                    case $this->DE_LINUX_GNOME:
                        //automatically in background
                        return 'gnome-open "' . $strFilename . '"';
                        break;
                    default:
                        trigger_error('FileLauncher: Unknown linux desktop environment "' . $this->nCurrentDE . '".', E_USER_NOTICE);
                        break;
                }
                break;
            default:
                trigger_error('FileLauncher: Unknown operating system "' . $this->nCurrentOS . '".', E_USER_NOTICE);
                break;
        }
    
        return false;
    }//function get_command($strFilename)



    /**
    *    launches a file
    *
    *    @param  string    The file to open
    *    @param  boolean   True if the application should be run in the background
    *
    *    @return boolean   True if all was ok, false if there has been a problem
    */
    function launch_file($strFilename, $bBackground = true)
    {
        $strCommand  = $this->get_command($strFilename, $bBackground);
        
        $arOutput    = array();
        $nReturnVar  = 0;
        exec($strCommand, $arOutput, $nReturnVar);
        
        return $nReturnVar == 0;
    }//function launch_file($strFilename, $bBackground = true)



}//class FileLauncher
?>