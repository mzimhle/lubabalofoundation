<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR .$_SERVER['DOCUMENT_ROOT'].'/library/classes/');


/* path constants */
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('LIBS', ROOT . '/library/');

require_once 'Template/Template.php';

$template = new Template(); // this is the outer template

$template->cache_dir = ROOT.'/cache/smarty/cache/';

global $template;
?> 