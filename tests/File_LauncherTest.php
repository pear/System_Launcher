<?php
/**
 * PHPUnit tests for File_Launcher
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

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../File/Launcher.php';

/**
 * File_Launcher with test-friendly methods.
 * 
 * @category File
 * @package  File_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.5.1
 */
class File_LauncherFake extends File_Launcher
{
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToWindows()
    {
        $this->nCurrentOS = self::$OS_WINDOWS;
    }
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToMac()
    {
        $this->nCurrentOS = self::$OS_MAC;
    }
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToLinux()
    {
        $this->nCurrentOS = self::$OS_LINUX;
    }
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToKde()
    {
        $this->nCurrentDE = self::$DE_LINUX_KDE;
    }
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToGnome()
    {
        $this->nCurrentDE = self::$DE_LINUX_GNOME;
    }
    /**
     * Helper
     * 
     * @return void
     */
    public function switchToLinuxWithPortland()
    {
        $this->nCurrentDE = self::$DE_LINUX_PORTLAND;
    }
    
    /**
     * Helper, to expose as public
     * 
     * @param string  $strFilename Filename
     * @param boolean $bBackground Run in background?
     * 
     * @return string
     */
    public function getCommand($strFilename, $bBackground)
    {
        return parent::getCommand($strFilename, $bBackground);
    }
}


/**
 * Test class for File_Launcher.
 * 
 * @category File
 * @package  File_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.5.1
 */
class File_LauncherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var File_Launcher
     */
    protected $launcher;
    
    /**
     * Create a fake to use, and its data
     *
     * @return void
     */
    protected function setUp()
    {
        $this->launcher = new File_LauncherFake;
        $this->file = 'foo.txt';
    }

    /**
     * Test for Portland
     *
     * @return void
     */
    public function testCommandOutputOnPortland()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToLinuxWithPortland();
        $this->assertEquals(
            'xdg-open \'foo.txt\'', $this->launcher->getCommand($this->file, true)
        );
    }
    
    /**
     * Test for Windows output
     *
     * @return void
     */
    public function testCommandOutputOnWindows()
    {
        $this->launcher->switchToWindows();
        $this->assertEquals(
            'start "" \'foo.txt\'',
            $this->launcher->getCommand($this->file, true)
        );
        $this->assertEquals(
            'start "" /WAIT \'foo.txt\'', 
            $this->launcher->getCommand($this->file, false)
        );
    }
    
    /**
     * Test for Mac output
     *
     * @return void
     */
    public function testCommandOutputOnMac()
    {
        $this->launcher->switchToMac();
        $this->assertEquals(
            'open \'foo.txt\'',
            $this->launcher->getCommand($this->file, true)
        );
    }
    
    /**
     * Test for KDE Linux output
     *
     * @return void
     */
    public function testCommandOutputOnKde()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToKde();
        $this->assertEquals(
            'kfmclient exec \'foo.txt\'',
            $this->launcher->getCommand($this->file, true)
        );
    }
    /**
     * Test for GNOME Linux output
     *
     * @return void
     */
    public function testCommandOutputOnGnome()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToGnome();
        $this->assertEquals(
            'gnome-open \'foo.txt\'',
            $this->launcher->getCommand($this->file, true)
        );
    }
    /**
     * Test to explain how "which" works.
     *
     * @return void
     */
    public function testWhichWithSilentOption()
    {
        exec("which -s ThisCommandReallyDoesNotExist", $output, $statusCode);
        $this->assertNotEquals(0, $statusCode);
        exec("which -s pear", $output, $statusCode);
        $this->assertEquals(0, $statusCode);
    }

}
?>