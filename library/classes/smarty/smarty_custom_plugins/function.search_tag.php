<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins

 * Smarty {File exists} function plugin
 *
 * Examples:
 * {search_section start=true end=true}
 * 
 * @author     	David Murray <dave@clickthinking.com>
 * @version    	1.0
 * @date 		01 November 2008
 * @param 		array
 * @param 		Smarty
 * @return 		string
 */
function smarty_function_search_tag($params, &$smarty)
{

	extract($params);
	
	//check we have the correct user agent
	if ( $_SERVER['HTTP_USER_AGENT'] == 'search_spider' )
	{
		if($start_no_index) return '<noindex>';
		if($end_no_index) return '</noindex>';
		
	}//end check for correct user agent
	
	return '';	
}
?>