<?php
/**
 * PHPUnit bootstrap glue
 */
$parent_folder = dirname(__FILE__) . '/..';
$system_folder = $parent_folder . '/System';
if (is_dir($system_folder)) {
	set_include_path($parent_folder . PATH_SEPARATOR . get_include_path());
}
