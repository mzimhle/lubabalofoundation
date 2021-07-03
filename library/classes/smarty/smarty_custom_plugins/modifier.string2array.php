<?php

/**
 * Smarty string2array modifier plugin
 *
 * Type:     modifier<br>
 * Name:     string2array<br>
 * Date:     Feb 25, 2007
 * Purpose:  convert csv to array
 * Input:    string to explode
 * @author   David Murray <david at clickthinking dot com>
 * @version 1.0
 * @param string
 * @return string
 */
function smarty_modifier_string2array($string)
{
    if ( isset($string) && ( strlen($string) > 0) ) {
		return explode(",",$string);
	}else{
		return null;
	}	
}


?>