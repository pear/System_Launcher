<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../File/Launcher.php';

/**
 * File_Launcher with test-friendly methods.
 */
class File_LauncherFake extends File_Launcher {
    
    public function switchToWindows()
    {
        $this->nCurrentOS = self::$OS_WINDOWS;
    }
    public function switchToMac()
    {
        $this->nCurrentOS = self::$OS_MAC;
    }
    public function switchToLinux()
    {
        $this->nCurrentOS = self::$OS_LINUX;
    }
    public function switchToKde()
    {
        $this->nCurrentDE = self::$DE_LINUX_KDE;
    }
    public function switchToGnome()
    {
        $this->nCurrentDE = self::$DE_LINUX_GNOME;
    }
    
    // http://www.linux.com/archive/articles/114183
    public function switchToLinuxWithPortland()
    {
        $this->nCurrentDE = self::$DE_LINUX_PORTLAND;
    }
    
    // Only exposed it as a public method
    public function getCommand($strFilename, $bBackground)
    {
        return parent::getCommand($strFilename, $bBackground);
    }
}


/**
 * Test class for File_Launcher.
 */
class File_LauncherTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var File_Launcher
     */
    protected $launcher;

    protected function setUp()
    {
        $this->launcher = new File_LauncherFake;
        $this->file = 'foo.txt';
    }

    public function testCommandOutputOnPortland()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToLinuxWithPortland();
        $this->assertEquals('xdg-open "foo.txt"', $this->launcher->getCommand($this->file, true));
    }
    
    public function testCommandOutputOnWindows()
    {
        $this->launcher->switchToWindows();
        $this->assertEquals('start "" "foo.txt"', $this->launcher->getCommand($this->file, true));
        $this->assertEquals('start "" /WAIT "foo.txt"', $this->launcher->getCommand($this->file, false));
    }
    
    public function testCommandOutputOnMac()
    {
        $this->launcher->switchToMac();
        $this->assertEquals('open "foo.txt"', $this->launcher->getCommand($this->file, true));
    }
    
    public function testCommandOutputOnKde()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToKde();
        $this->assertEquals('kfmclient exec "foo.txt"', $this->launcher->getCommand($this->file, true));
    }
    
    public function testCommandOutputOnGnome()
    {
        $this->launcher->switchToLinux();
        $this->launcher->switchToGnome();
        $this->assertEquals('gnome-open "foo.txt"', $this->launcher->getCommand($this->file, true));
    }
    
    public function testWhichWithSilentOption()
    {
        exec("which -s ThisCommandReallyDoesNotExist", $output, $statusCode);
        $this->assertNotEquals(0, $statusCode);
        exec("which -s pear", $output, $statusCode);
        $this->assertEquals(0, $statusCode);
    }

}
?>