<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins

 * Smarty {File exists} function plugin
 *
 * Examples:
 * {file_exists src="file source"}
 * @author     Johan Steyn <johan@clickthinking.com>
 * @version    1.0
 * @date 19 October 2007
 * @param array
 * @param Smarty
 * @return boolean
 */
function smarty_function_file_exists($params, &$smarty)
{

	extract($params);
	if(!preg_match("/http:/",$src)) $src = $_SERVER['DOCUMENT_ROOT'].$src;
	if(	@file($src)	) return true;
	return false;	
}
?>