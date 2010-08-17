<?php
require_once 'PHPUnit/Framework.php';
 
require_once 'File_LauncherTest.php';
 
class AllTests
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite('File_LauncherTest');
    }
}
?>