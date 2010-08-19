<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PHPUnit test suite for System_Launcher
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

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'System_Launcher_AllTests::main');
}

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once dirname(__FILE__) . '/System_LauncherTest.php';
 
/**
 * PHPUnit tests for System_Launcher
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
class System_Launcher_AllTests
{
    
    // {{{ main()
        
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
    
    // }}}
    // {{{ suite()
    
    /**
     * Test suite for System_Launcher
     * 
     * @return Full test suite
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite('System_LauncherTest');
    }
    
    // }}}
}

if (PHPUnit_MAIN_METHOD == 'System_Launcher_AllTests::main') {
    System_Launcher_AllTests::main();
}
?>