<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PHPUnit tests for File_Launcher
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

require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__).'/../System/Launcher.php';

/**
 * Test class for System_Launcher.
 * 
 * @category System
 * @package  System_Launcher
 * @author   Christian Weiske <cweiske@php.net>
 * @author   Olle Jonsson <olle.jonsson@gmail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://github.com/olleolleolle/File_Launcher
 * @since    File available since Release 0.5.1
 */
class System_LauncherTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test for Portland
     *
     * @return void
     */
    public function testCommandOutputOnPortland()
    {
        $driver = new System_Launcher_Driver_Portland;
        $this->assertEquals(
            'xdg-open %s', $driver->getCommand(true)
        );
    }
    
    /**
     * Test for Windows output
     *
     * @return void
     */
    public function testCommandOutputOnWindows()
    {
        $driver = new System_Launcher_Driver_Windows;
        $this->assertEquals(
            'start "" /WAIT %s',
            $driver->getCommand(true)
        );
        $this->assertEquals(
            'start "" %s',
            $driver->getCommand(false)
        );
    }
    
    /**
     * Test for Mac output
     *
     * @return void
     */
    public function testCommandOutputOnMac()
    {
        $driver = new System_Launcher_Driver_Mac;
        $this->assertEquals(
            'open %s',
            $driver->getCommand(true)
        );
    }
    
    /**
     * Test for KDE Linux output
     *
     * @return void
     */
    public function testCommandOutputOnKde()
    {
        $driver = new System_Launcher_Driver_KDE;
        $this->assertEquals(
            'kfmclient exec %s',
            $driver->getCommand(true)
        );
    }
    /**
     * Test for GNOME Linux output
     *
     * @return void
     */
    public function testCommandOutputOnGnome()
    {
        $driver = new System_Launcher_Driver_GNOME;
        $this->assertEquals(
            'gnome-open %s',
            $driver->getCommand(true)
        );
    }
    /**
     * Test to explain how "which" works.
     *
     * @return void
     */
    public function testWhichWithReturnedStatusCodes()
    {
        exec("which ThisCommandReallyDoesNotExist", $output, $statusCode);
        $this->assertNotEquals(0, $statusCode);
        exec("which pear", $output, $statusCode);
        $this->assertEquals(0, $statusCode);
    }
    
    /**
     * Run without any passing drivers to see that the Exception is used.
     * 
     * @expectedException System_Launcher_Exception
     * @return void
     */
    public function testMakeSureExceptionRunsOnBadPlatform()
    {
        $noDrivers = array();
        $launcher = new System_Launcher($noDrivers);
        $launcher->launch('');
    }
}
?>