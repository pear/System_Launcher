<?php
/**
 * PHPUnit test suite for File_Launcher
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
 
require_once 'File_LauncherTest.php';
 
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
class AllTests
{
    /**
     * Test suite for File_Launcher
     * 
     * @return Full test suite
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite('File_LauncherTest');
    }
}
?>