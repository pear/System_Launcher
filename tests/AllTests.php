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
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.1.0
 */

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'System_Launcher_AllTests::main');
}

require_once 'PHPUnit/Autoload.php';

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
 * @link     http://github.com/olleolleolle/System_Launcher
 * @since    File available since Release 0.1.0
 */
class System_Launcher_AllTests
{
    
    // {{{ main()
        
    /**
     * Test suite launcher for System_Launcher
     * 
     * @return void
     */
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
        $suite = new PHPUnit_Framework_TestSuite('System_Launcher tests');
        /** Add testsuites, if there are any */
        $suite->addTestFiles(
            glob(__DIR__ . '/System_LauncherTest.php', GLOB_BRACE)
        );

        return $suite;
    }
    
    // }}}
}

if (PHPUnit_MAIN_METHOD == 'System_Launcher_AllTests::main') {
    System_Launcher_AllTests::main();
}
