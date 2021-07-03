<?php
/*
 * Smarty {File exists} modifier plugin
 *
 * Examples:
 * {source|file_exists}
 *
 * @author     Johan Steyn <johan@clickthinking.com>
 * @version    1.0
 * @date 19 October 2007
 * @ src String (filename or url)
 * @return boolean
 */
function smarty_modifier_file_exists($src)
{
	if(!preg_match("/http:/",$src)){
		if (strpos($src,$_SERVER['DOCUMENT_ROOT']) === false) $src = $_SERVER['DOCUMENT_ROOT'].$src; // check to make sure document root is also included
	 	if(	@file_exists($src)	) return true;		
	 }else{
		if(	@file($src)	) return true;
	}
	return false;	
}
?>